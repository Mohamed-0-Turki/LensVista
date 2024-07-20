const userMenuBtn = document.querySelector("#user-menu-btn")
const userMenu = document.querySelector("#user-menu")
const sideBarBtn = document.querySelector("#navbar-menu-btn")
const sideBar = document.querySelector("#navbar-menu")
const messagesMenuBtn = document.querySelector("#messages-menu-btn")
const messagesMenu = document.querySelector("#messages-menu")
const dashboardSideBarOpenBtn = document.querySelector("#dashboard-side-bar-open-btn")
const dashboardSideBarCloseBtn = document.querySelector("#dashboard-side-bar-close-btn")
const dashboardSideBar = document.querySelector("#dashboard-side-bar")


if (userMenuBtn !== null) {
    toggleMenuOnClick(userMenuBtn, userMenu);
    closeMenuOnClickOutside(userMenuBtn, userMenu);
}

if (sideBarBtn !== null) {
    toggleMenuOnClick(sideBarBtn, sideBar);
    closeMenuOnClickOutside(sideBarBtn, sideBar);
}

if (dashboardSideBarOpenBtn !== null) {
    toggleMenuOnClick(dashboardSideBarOpenBtn, dashboardSideBar);
    toggleMenuOnClick(dashboardSideBarCloseBtn, dashboardSideBar);
}

if (messagesMenuBtn !== null) {
    toggleMenuOnClick(messagesMenuBtn, messagesMenu);
}

// Get the button
const scrollToTopBtn = document.getElementById('scroll-to-top-btn');

// Show the button when the user scrolls down 100px from the top of the document
window.onscroll = function() {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        scrollToTopBtn.style.display = 'block';
    } else {
        scrollToTopBtn.style.display = 'none';
    }
};

// When the user clicks on the button, scroll to the top of the document
scrollToTopBtn.addEventListener('click', function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

function updateCartQuantity() {
    $.ajax({
        url: 'http://localhost/LensVista/cart/getTotalCartQuantity',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#cart-quantity').text(data.total_quantity);
        },
        error: function() {
            console.error('Failed to fetch cart quantity.');
        }
    });
}

// Call the function on page load
$(document).ready(function() {
    updateCartQuantity();

    setInterval(updateCartQuantity, 30000);
});


$(document).ready(function () {
    $("#search-input").on("keyup", function () {
        let modelName = $(this).val();

        if (modelName.length > 0) {
            $.ajax({
                method: "POST",
                url: `http://localhost/LensVista/products/getProductsByModel/${modelName}`,
                dataType: 'json',
                success: function(data) {
                    $("#search-results").empty(); // Clear previous results

                    if (data.length > 0) {
                        $("#search-results-container").removeClass("hidden");

                        data.forEach(function (product) {
                            $("#search-results").append(`
                                <li class="group w-full h-24 rounded-3xl hover:bg-light-gray ease-in-out duration-150">
                                    <a class="group-hover:text-cerulean-depths h-full flex flex-row items-center justify-around gap-3 px-5" href="http://localhost/LensVista/products/index/${product.frame_ID}">
                                        <img class="w-16 h-16 object-cover rounded-lg" src="http://localhost/LensVista/public/uploads/images/${product.image_url}" alt="" srcset="" id="image-search">
                                        <div class="h-full overflow-y-clip">
                                            <p class="capitalize text-xl font-bold" id="model-search">${product.model}</p>
                                            <p class="text-sm text-ellipsis overflow-hidden" id="description-search">${product.description}</p>
                                        </div>
                                    </a>
                                </li>
                            `);
                        });
                    } else {
                        $("#search-results-container").addClass("hidden");
                    }
                },
                error: function() {
                    console.error('Failed to fetch products.');
                    $("#search-results-container").addClass("hidden");
                }
            });
        } else {
            $("#search-results").empty();
            $("#search-results-container").addClass("hidden");
        }
    });
});