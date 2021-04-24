const BASE_URL = "http://localhost/Gigatronic_Shop/"

$(document).ready(function () {
    populateAllArticles()
    showPagination(0)
})

function populateAllArticles() {
    $.ajax({
        url: "models/products/ajaxArticles.php",
        method: "POST",
        dataType: "json",
        data: {
            id: 1
        },
        success: function (data) {
            printArticles(data)
        },
        error: function (xhr, status, error) {
            console.log(xhr.status)
        }
    })
}

function printArticles(articles) {
    let print = ""
    for (let article of articles) {
        print += `
        <div class="col-md-3 col-lg-3 my-4">
            <div class="featured-container p-5">
                <img src="${article.image}" alt="${article.alt}" class="img-fluid" />
                <button name="view" value="View" class="view_data" id="${article.idArticle}">
                    <i class="fa fa-search"></i>
                </button>
            </div>
            <h6 class="text-center my-2">${article.name}</h6>
            <h6 class="text-center">
                <span>$${article.price}</span>
            </h6>
        </div>
        `
    }
    $("#allArticles").html(print)
}

$(document).on('click', '.view_data', function (e) {
    e.preventDefault()
    let idArticle = $(this).attr('id')

    $.ajax({
        url: "views/pages/articleDetails.php",
        method: "POST",
        data: {
            idArticle: idArticle
        },
        success: function (data) {
            $('#article_detail').html(data)
            $('#dataModal').modal("show")
        }
    })
})

function showPagination(id) {
    $.ajax({
        url: "models/products/pagination.php",
        method: "POST",
        dataType: "json",
        data: {
            id: id
        },
        success: function (data) {
            let print = ``
            let number = data.numOfArticles
            let numberOfLinks = Math.ceil(number / 4)
            for (let i = 1; i <= numberOfLinks; i++) {
                if (i == 1) {
                    print += `<li class='active'><a href='javascript:void(0)' class='paginationLink' data-id='${i}'>${i}</a></li>`
                } else {
                    print += `<li><a href='javascript:void(0)' class='paginationLink' data-id='${i}'>${i}</a></li>`
                }
            }
            $("#pagination-list").html(print)
        },
        error: function (xhr, status, error) {
            console.log(xhr.status)
            console.log(error)
            console.log(xhr.responseText)
        }
    })
}

$("#ddlCategory").change(function () {
    let idCategory = $(this).val()
    showPagination(idCategory)

    $.ajax({
        url: "models/products/filter.php",
        method: "POST",
        dataType: "json",
        data: {
            idPagination: 1,
            idCategory: idCategory,
            send: true
        },
        success: function (data) {
            printArticles(data)
        },
        error: function (xhr, status, error) {
            console.log(xhr.status)
        }
    })
})

$("#btnSearch").click(function (e) {
    e.preventDefault()
    let searchValue = $("#searchInput").val().trim().toLowerCase()

    if (searchValue != "") {
        $.ajax({
            url: "models/products/search.php",
            method: "POST",
            dataType: "json",
            data: {
                searchValue: searchValue,
                send: true
            },
            success: function (data) {
                printArticles(data)
                $("#pagination").hide()
            },
            errror: function (xhr, status, error) {
                console.log(xhr.status)
            }
        })
    } else {
        $("#allArticles").html("")
    }
})

$("#pagination").on("click", ".paginationLink", function () {
    let id = $(this).data("id")
    let idCategory = $("#ddlCategory").val()
    $("#pagination-list .active").removeAttr("class")
    $(this).parent().attr("class", "active")

    $.ajax({
        url: "models/products/filter.php",
        method: "POST",
        dataType: "json",
        data: {
            idPagination: id,
            idCategory: idCategory,
            send: true
        },
        success: function (data) {
            printArticles(data)
        },
        error: function (xhr, status, error) {
            console.log(xhr.status)
            console.log(error)
        }
    })
})

$('.update').hide()

$('.update-product').click(function (e) {
    e.preventDefault()
    $('.update').show(800)

    let idArticle = $(this).data('id')

    $.ajax({
        url: "models/products/ajaxGetArticle.php",
        method: "POST",
        dataType: "json",
        data: {
            id: idArticle
        },
        success: function (data) {
            $("#hiddenProductID").val(data.idArticle)
            $("#productName").val(data.name)
            $("#taDescription").val(data.description)
            $("#productPrice").val(data.price)
            $("#srcImage").val(data.image)
            $("#productAlt").val(data.alt)
            $("#ddlCategory").val(data.idCategory)

            $("#emptyImage").attr("src", data.image)
            $("#emptyImage").attr("alt", data.alt)
        },
        error: function (xhr, status, error) {
            console.log(xhr.status)
            console.log(error)
        }
    })
})

$('.update-user').click(function (e) {
    e.preventDefault()
    $('.update').show(800)

    let idUser = $(this).data('id')

    $.ajax({
        url: "models/users/ajaxGetUser.php",
        method: "POST",
        dataType: "json",
        data: {
            id: idUser
        },
        success: function (data) {
            $("#hiddenUserId").val(data.idUser)
            $("#tbFirstName").val(data.first_name)
            $("#tbLastName").val(data.last_name)
            $("#tbEmail").val(data.email)
            $("#tbUsername").val(data.username)
            $("#ddlRole").val(data.idRole)
            let DatetimeArray = data.date_registration.split(" ")
            $("#dateRegistration").val(DatetimeArray[0])
            $("input[name='chbActive']").removeAttr('checked')
            if (data.active == 1) {
                $("input[name='chbActive']").prop('checked', true)
                $("input[name='chbActive']").val(data.active)
            }
        },
        error: function (xhr, statusTxt, error) {
            let status = xhr.status

            switch (status) {
                case 500:
                    console.log("Error on server")
                    break;
                case 404:
                    console.log("Page not found")
                    break;
                default:
                    console.log("Error: " + status + " - " + statusTxt)
            }
        }
    })
})

