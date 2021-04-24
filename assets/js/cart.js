function allArticlesInCart() {
    return JSON.parse(localStorage.getItem('articles'))
}

if (!allArticlesInCart()) {
    localStorage.setItem('articles', JSON.stringify([]))
    $("button-buy").hide()
}

$(document).on('click', '.add-to-cart', function () {
    alert("You successfully added item to cart.")
    let id = $(this).data('id')
    let articles = allArticlesInCart()

    if (articles.filter(a => a.id == id).length) {
        for (let article of articles) {
            if (article.id == id) {
                article.quantity++
                break
            }
        }
        localStorage.setItem('articles', JSON.stringify(articles))
    } else {
        articles.push({
            id: id,
            quantity: 1
        })
        localStorage.setItem('articles', JSON.stringify(articles))
    }
})


populateCart()
function populateCart() {
    let articles = allArticlesInCart()

    $.ajax({
        url: 'models/products/ajaxAllArticles.php',
        method: 'POST',
        dataType: 'json',
        success: function (data) {
            data = data.filter(a => {
                for (let article of articles) {
                    if (article.id == a.idArticle) {
                        a.quantity = article.quantity
                        return true
                    }
                }
                return false
            })
            makeTable(data)
        },
        error: function (xhr, status, error) {
            console.log(xhr.status)
            console.log(error)
        }
    })
}

$('#cart').on('click', '.remove-cart-item', function () {
    let articles = allArticlesInCart()
    let id = $(this).data('id')
    let showRem = articles.filter(a => a.id != id)
    localStorage.setItem('articles', JSON.stringify(showRem))
    populateCart()
})

if (!allArticlesInCart().length) {
    $('#cart').html(`
    <div class="cart-row">
        <span class="cart-item cart-header cart-column">ITEM</span>
        <span class="cart-price cart-header cart-column">PRICE</span>
        <span class="cart-quantity cart-header cart-column">QUANTITY</span>
    </div>
    `)
    $("#button-buy").hide()
}

function makeTable(data) {
    let print = `
    <div class="cart-row">
        <span class="cart-item cart-header cart-column">ITEM</span>
        <span class="cart-price cart-header cart-column">PRICE</span>
        <span class="cart-quantity cart-header cart-column">QUANTITY</span>
        <span class="cart-header cart-column">TOTAL</span>
    </div>
    `

    for (let i of data) {
        print += `
        <div class='cart-items'>
            <div class='cart-row'>
                <div class='cart-item cart-column'>
                    <img src='${i.image}' alt='${i.alt}' class='cart-item-image' width='100' height='100'>
                    <span class='cart-item-title'>${i.name}</span>
                </div>
                <span class='cart-price cart-column'>$${i.price}</span>
                <div class='cart-quantity cart-column'>
                    <input type='number' class='cart-quantity-input' value='${i.quantity}' disabled>
                    <button class='btn btn-danger remove-cart-item' type='button' data-id='${i.idArticle}'>REMOVE</button>
                </div>
                <span class="cart-total-price align-self-center">$${Number(i.price) * Number(i.quantity)}<span>             
            </div>
        </div>
      `
    }

    $("#cart").html(print)
}

$("#button-buy").hide()

if (allArticlesInCart()) {
    if (allArticlesInCart().length) {
        $("#button-buy").show()
        $("#button-buy").click(function() {
            $("button-buy").hide()
            alert("Your order is successfully done.")
            localStorage.removeItem('articles')
        })
    }
}