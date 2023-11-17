<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Arturia') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        //Js
        var cartItemDB = openDatabase("Carddb", "0.1", "Testing  Database", 1024 * 1024);
        if (window.openDatabase) {
            cartItemDB.transaction(function(t) {
                t.executeSql(
                    "CREATE TABLE IF NOT EXISTS cart_item (id INTEGER PRIMARY KEY, product_id INTEGER, count INTEGER)"
                );

            });

        } else {
            alert("WebSQL is not supported by your browser!");
        }

        function updateDrafts(transaction, results) {}

        function findAll() {
            if (cartItemDB) {
                cartItemDB.transaction(function(t) {
                    t.executeSql("SELECT * FROM cart_item", [], async (_, results) => {

                        for (i = 0; i < results.rows.length; i++) {
                            var row = results.rows.item(i);
                            await getProduct(row.product_id, row.count)
                        }
                        if(document.getElementById('total')) {
                            document.getElementById('total').innerHTML = `Order total (${results.rows.length})`
                            
                            document.getElementById('cart-itens').value = JSON.stringify( results.rows)
                            console.log(JSON.stringify( results.rows));
                        }
                    });
                });
            } else {
                alert("db not found, your browser does not support web sql!");
            }
        }

        async function  addElement(productId, count,data, element)  {
           
            const template = document.querySelector('#itens-cart-tem')
            var clone = template.content.cloneNode(true);
            console.log(data);
            clone.querySelector(".name").innerHTML = data.name
            clone.querySelector(".count").innerHTML = count
            clone.querySelector(".price").innerHTML = `R$ ${data.sale_price * count}`
            clone.querySelector("img").src = data.image

            clone.querySelector(".addcount").onclick = () => updateCount(count + 1, data.id)
            clone.querySelector(".removecount").onclick = () => updateCount(count - 1, data.id)
            clone.querySelector('div').id = `${element}-${data.id}`

            if(document.getElementById(element)){
                document.getElementById(element).appendChild(clone)
            }
          
            
            
        }

        function addProductCart(productId, count = 1) {
            if (count == 0) {
                deleteCart(productId)
            } else if (cartItemDB) {
                cartItemDB.transaction(function(t) {
                    t.executeSql("SELECT * FROM cart_item WHERE product_id = ?;", [productId], (transaction,
                        results) => addOrUpdate(transaction, results, productId, count));
                })
            } else {
                alert("db not found, your browser does not support web sql!");
            }
        }


        function addOrUpdate(transaction, results, productId, count) {
            if (results.rows.length > 0) {
                const product = results.rows.item(0);
                const newCount = product.count + 1
                updateCount(newCount, product.product_id)
            } else {
                addNewProductCart(count, productId)
            }
        }

        async function getProduct(productId, count) {
            const res = await fetch(`{{ url('/product/id') }}/${productId}`);
                        var data = await res.json()
                        await addElement(productId, count, data, 'itens-checkout')
                        await addElement(productId, count, data,'itens-cart')
        }

        function addNewProductCart(count, productId) {
            if (cartItemDB) {
                cartItemDB.transaction(function(t) {
                    t.executeSql("INSERT INTO cart_item (product_id, count) VALUES (?, ?)", [productId, count], async () => getProduct(productId, count));
                });
            } else {
                alert("db not found, your browser does not support web sql!");
            }
        }


        function updateCount(count, productId) {
            console.log(productId);
            if( count == 0) {
                deleteCart(productId)
            } else if (cartItemDB) {
                cartItemDB.transaction(function(t) {
                    t.executeSql("UPDATE cart_item SET count = ?  WHERE product_id = ?;", [count, productId],async () => {
                        const res = await fetch(`{{ url('/product/id') }}/${productId}`);
                        const data = await res.json()
                        updateElenemt(count, productId, data , 'itens-checkout')
                        updateElenemt(count, productId, data , 'itens-cart')

                });
                });
            } else {
                alert("db not found, your browser does not support web sql!");
            }
        }

        async function updateElenemt(count, productId, data, element) {
            
            if(document.getElementById(element)) {

                element = document.getElementById(element).querySelector(`#${element}-${productId}`)
            element.querySelector('.count').innerHTML = count
            element.querySelector(".price").innerHTML = `R$ ${data.sale_price * count}`
            element.querySelector(".addcount").onclick = () => updateCount(count + 1, productId)
            element.querySelector(".removecount").onclick = () => updateCount(count - 1, productId)
        }
        }

        function deleteCart(productId) {
            if (cartItemDB) {
                cartItemDB.transaction(function(t) {
                    t.executeSql("DELETE FROM cart_item WHERE product_id=?", [productId], () => revoveElement(productId));
                });
            } else {
                alert("db not found, your browser does not support web sql!");
            }
        }

        function revoveElement(productId) {
            document.querySelector(`#product-${productId}`).remove()
        }
        findAll()

        function finalizeCard() {
            alert('alalal');
        }
    </script>

</head>

<body class="font-sans text-gray-900 antialiased  bg-gray-100 dark:bg-gray-900">
    {{ $slot }}
</body>

</html>
