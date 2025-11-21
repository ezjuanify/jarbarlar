        </div>
        <?php
        /**
         * Hook before site content
         *
         */
        do_action('ebbe/site-end');


        ?>
        </div>
        </div>
        </div>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

        <?php wp_footer(); ?>

        <script>
          document.addEventListener('DOMContentLoaded', () => {
            // setTimeout(() => {



            //   // if(document.querySelector('#woocommerce_product_categories-12')){
            //   const clickbtn = document.querySelector('#woocommerce_product_categories-12 .select2');
            //   // console.log("click btn" + clickbtn);
            //   if (!clickbtn) return;

            //   clickbtn.addEventListener('click', () => {
            //     // alert('hello')
            //     setTimeout(() => {
            //       // alert('in function');


            //       const allItems = document.querySelectorAll("#select2-product_cat-results > li");


            //       let afterWineVarietal = false;
            //       allItems.forEach(item => {
            //         console.log('hello' + allItems)
            //         if (item.textContent.includes("Wine Varietal")) {
            //           afterWineVarietal = true;
            //           item.style.display = "none";
            //         } else if (afterWineVarietal && item.textContent.includes("\u00A0\u00A0\u00A0")) {
            //           item.style.display = ""; // Ensure it's visible
            //         } else {
            //           item.style.display = "none";
            //         }
            //       });
            //     }, 0);
            //   })
            // }, 1000);
            // }
          });
          document.addEventListener('DOMContentLoaded', function () {
  if (document.querySelector('.prd_item')) {
    // Code for when `.prd_item` exists
    document.querySelectorAll('input[type="radio"]').forEach(function (radioButton) {
      radioButton.addEventListener('change', function () {
        const selectedPrice = this.getAttribute('data-price'); // Get the selected variant price
        const productId = this.name.split('-')[1]; // Extract product ID from name attribute

        // Update the price container
        const priceElement = document.getElementById('product-price-' + productId);
        if (priceElement && selectedPrice) {
          // Format the price in WooCommerce HTML structure
          const formattedPrice = `
            <div class="woocommerce-variation-price">
                <span class="price">
                    <span class="woocommerce-Price-amount amount">
                        <bdi><span class="woocommerce-Price-currencySymbol">$</span>${parseFloat(selectedPrice).toFixed(2)}</bdi>
                    </span>
                </span>
            </div>
          `;

          // Replace the content of the price container with the new price
          priceElement.innerHTML = formattedPrice;
        }

        const addToCartButton = document.getElementById('add-to-cart-button-' + productId);
        const variationInput = document.getElementById('variation-id-' + productId);
        if (addToCartButton && variationInput) {
          variationInput.value = this.getAttribute('data-variation-id'); // Set the selected variation ID
          addToCartButton.innerText = 'Add to Cart'; // Change button text
          addToCartButton.disabled = false; // Enable the button
          addToCartButton.classList.remove('select-options'); // Remove the Select Option class
          addToCartButton.classList.add('add-to-cart'); // Add the Add to Cart class
        }
      });
    });
  } else {
    // Code for when `.prd_item` does not exist
    document.querySelectorAll('input[type="radio"]').forEach(function (radioButton) {
      radioButton.addEventListener('change', function () {
        const selectedPrice = this.getAttribute('data-price');
        const productId = this.name.split('-')[1];
        const priceElement = document.getElementById('product-price-' + productId);

        if (selectedPrice && priceElement) {
          // Update the price dynamically
          priceElement.innerHTML = `
            <div class="woocommerce-variation-price">
                <span class="price">
                    <span class="woocommerce-Price-amount amount">
                        ${selectedPrice}
                    </span>
                </span>
            </div>
          `;
        }
      });
    });
  }
});

          document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.custom_characteristics').forEach((it) => {
              const attributeName = it.querySelector('.attribute-name'); // Find the child element
              if (attributeName && attributeName.innerText.trim() === 'Bundle Deal') {
                it.setAttribute('style', 'display: none !important;'); // Apply inline style with !important
              }
            });
            const timerSection = document.querySelector(".timer-section");
            const daysElement = document.getElementById("timer-days");
            const hoursElement = document.getElementById("timer-hours");
            const minutesElement = document.getElementById("timer-minutes");
            const secondsElement = document.getElementById("timer-seconds");

            const endTime = timerSection.getAttribute("data-end-time");
            const endDateTime = new Date(endTime).getTime();

            function addFlipAnimation(element, newValue, label) {
              // Create new animated flip element
              const flipCard = document.createElement("span");
              flipCard.classList.add("flip-card", "flip-card-inner");
              flipCard.textContent = newValue;

              // Clear previous value and add the new animated element
              element.innerHTML = "";
              element.appendChild(flipCard);

              // Append the static label (e.g., "days", "hours")
              const staticText = document.createElement("span");
              staticText.textContent = label;
              element.appendChild(staticText);

              // Remove animation class after animation ends
              setTimeout(() => flipCard.classList.remove("flip-card-inner"), 600);
            }

            function updateCountdown() {
              const now = new Date().getTime();
              const distance = endDateTime - now;

              if (distance <= 0) {
                daysElement.innerHTML = `<span class="flip-card">00</span><span>days</span>`;
                hoursElement.innerHTML = `<span class="flip-card">00</span><span>hours</span>`;
                minutesElement.innerHTML = `<span class="flip-card">00</span><span>minutes</span>`;
                secondsElement.innerHTML = `<span class="flip-card">00</span><span>seconds</span>`;
                clearInterval(timerInterval);
                return;
              }

              const days = Math.floor(distance / (1000 * 60 * 60 * 24));
              const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
              const seconds = Math.floor((distance % (1000 * 60)) / 1000);

              if (daysElement.querySelector(".flip-card").textContent !== `${days}`) {
                addFlipAnimation(daysElement, days, "days");
              }

              if (hoursElement.querySelector(".flip-card").textContent !== `${hours}`) {
                addFlipAnimation(hoursElement, hours, "hours");
              }

              if (minutesElement.querySelector(".flip-card").textContent !== `${minutes}`) {
                addFlipAnimation(minutesElement, minutes, "minutes");
              }

              if (secondsElement.querySelector(".flip-card").textContent !== `${seconds}`) {
                addFlipAnimation(secondsElement, seconds, "seconds");
              }
            }

            // Initialize timer elements with placeholders
            [daysElement, hoursElement, minutesElement, secondsElement].forEach((el) => {
              el.innerHTML = `<span class="flip-card">00</span><span>${el.id.split("-")[1]}</span>`;
            });

            const timerInterval = setInterval(updateCountdown, 1000);
            updateCountdown();
            // document.querySelectorAll('.type-product').forEach(item => {
            //   item.className = '';
            //   item.classList.add('realted-product')
            // });
            const dropdowns = document.querySelectorAll('#woocommerce_product_categories-12 select#product_cat');

            // Iterate over each dropdown
            dropdowns.forEach(selectElement => {
              const options = Array.from(selectElement.options); // Get all options
              let showLevel1 = false; // Flag to track if we're inside the desired parent category

              options.forEach(option => {
                if (option.classList.contains('level-0') && option.text.trim() === "Wine Varietal") {
                  // Found the desired level-0 parent category
                  showLevel1 = true; // Enable flag
                  option.style.display = "none"; // Optionally hide the parent category
                } else if (option.classList.contains('level-1') && showLevel1) {
                  // Show level-1 subcategories that follow the desired level-0
                  option.style.display = "block";
                } else {
                  // Hide all other options
                  option.style.display = "none";
                }
              });
            });

          });
          $(document).ready(function() {
            function initSlickSlider(selector) {
              if ($(window).width() < 1030) {
                if (!$(selector).hasClass('slick-initialized')) {
                  $(selector).slick({
                    dots: false,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    responsive: [{
                        breakpoint: 1024,
                        settings: {
                          slidesToShow: 3,
                          slidesToScroll: 3,
                         	 dots: true,
							 infinite: true,
                          autoplay: true,
                          autoplaySpeed: 3000,
                          arrows: false,
                         
                        }
                      },
                      {
                        breakpoint: 700,
                        settings: {
                          slidesToShow: 2,
							 dots: true,
                          slidesToScroll: 2,
							
							 infinite: true,
                          autoplay: true,
                          autoplaySpeed: 3000,
                          arrows: false,
                        }
                      },
                      {
                        breakpoint: 480,
                        settings: {
                          slidesToShow: 2,
                          slidesToScroll: 2,
								 dots: true,
							 infinite: true,
                          autoplay: true,
                          autoplaySpeed: 3000,
                          arrows: false,
                         
                        }
                      }
                    ]
                  });
                }
              } else {
                if ($(selector).hasClass('slick-initialized')) {
                  $(selector).slick('unslick');
                }
              }
            }

            // Initialize slider for both selectors on page load
            initSlickSlider('.custom-products-list.grid');
            initSlickSlider('.related .products.columns-4');

            // Reinitialize slider on window resize
            $(window).resize(function() {
              initSlickSlider('.custom-products-list.grid');
              initSlickSlider('.related .products.columns-4');
            });
          });

          $(document).ready(function() {

            function initSlickSlider() {
              if ($(window).width() < 1080) {
                if (!$('.collectionParent_wrapper').hasClass('slick-initialized')) {
                  $('.collectionParent_wrapper').slick({
                    dots: true,
                    infinite: false,
                    speed: 300,
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    responsive: [{
                        breakpoint: 999,
                        settings: {
                          slidesToShow: 2,
                          slidesToScroll: 1,
                          infinite: true,
                          dots: true
                        }
                      },
                      {
                        breakpoint: 600,
                        settings: {
                          slidesToShow: 2,
                          slidesToScroll: 1
                        }
                      },
                      {
                        breakpoint: 480,
                        settings: {
                          slidesToShow: 1,
                          slidesToScroll: 1,
                          arrows: false,
                        }
                      }
                      // You can unslick at a given breakpoint now by adding:
                      // settings: "unslick"
                      // instead of a settings object
                    ]
                  });
                }
              } else {
                if ($('.collectionParent_wrapper').hasClass('slick-initialized')) {
                  $('.collectionParent_wrapper').slick('unslick');
                }
              }
            }

            // Initialize slider on page load
            initSlickSlider();

            // Reinitialize slider on window resize
            $(window).resize(function() {
              initSlickSlider();
            });

            function bloginitSlickSlider() {
              if ($(window).width() < 1030) {
                if (!$('.blog-articles-container').hasClass('slick-initialized')) {
                  $('.blog-articles-container').slick({
                    dots: true,
                    infinite: false,
                    speed: 300,
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    responsive: [{
                        breakpoint: 999,
                        settings: {
                          slidesToShow: 2,
                          slidesToScroll: 1,
                          infinite: true,
                          dots: true
                        }
                      },
                      {
                        breakpoint: 600,
                        settings: {
                          slidesToShow: 1,
                          slidesToScroll: 1
                        }
                      },
                      {
                        breakpoint: 480,
                        settings: {
                          slidesToShow: 1,
                          slidesToScroll: 1,
                          arrows: false,
                        }
                      }
                      // You can unslick at a given breakpoint now by adding:
                      // settings: "unslick"
                      // instead of a settings object
                    ]
                  });
                }
              } else {
                if ($('.blog-articles-container').hasClass('slick-initialized')) {
                  $('.blog-articles-container').slick('unslick');
                }
              }
            }

            // Initialize slider on page load
            bloginitSlickSlider();

            // Reinitialize slider on window resize
            $(window).resize(function() {
              bloginitSlickSlider();
            });
          });
          // for collection price
          // if (!window.location.pathname.includes('/product/')) {
          const priceContainers = document.querySelectorAll('.price');

          priceContainers.forEach(priceDiv => {
            const insElement = priceDiv.querySelector('ins bdi');
            const delElement = priceDiv.querySelector('del bdi');

            // Check if both the ins and del elements exist for the current price container
            if (insElement && delElement) {
              // Function to extract numerical value from HTML string
              function extractPrice(htmlString) {
                // Create a temporary DOM element to parse the HTML string
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = htmlString;
                // Extract the text content and remove any non-numeric characters except the decimal point
                const priceText = tempDiv.textContent || tempDiv.innerText || '';
                const numericValue = parseFloat(priceText.replace(/[^0-9.]/g, ''));
                return isNaN(numericValue) ? 0 : numericValue;
              }

              // Extract numerical prices
              const originalPrice = extractPrice(insElement.innerHTML);
              const discountedPrice = extractPrice(delElement.innerHTML);

              // Calculate the difference
              const difference = Math.abs(originalPrice - discountedPrice).toFixed(2);

              // Create a new element to display the difference
              const differenceElement = document.createElement('span');
              differenceElement.classList.add('diffecr-priceelment');
              differenceElement.textContent = `Save $${difference}`;

              // Append the difference element to the price container
              priceDiv.appendChild(differenceElement);
            }
          });
          // }
          // Debounce function
          let loadingproduct = ` <style> 
  .loadingone {
    border: 5px solid black; /* Outer border */
    border-top: 5px solid white; /* Top border color */
    border-radius: 50%; /* Make it a circle */
    width: 30px;
    height: 30px;
    animation: spin 1s linear infinite; /* Infinite spinning animation */
  }

  @keyframes spin {
    from {
      transform: rotate(0deg);
    }
    to {
      transform: rotate(360deg);
    }
  }
</style>
<div id="loaderjs" class="loadingone"></div>`

          function debounce(func, delay) {
            let timeout;
            return function(...args) {
              clearTimeout(timeout);
              timeout = setTimeout(() => func.apply(this, args), delay);
            };
          }
          document.querySelector('.search-field').addEventListener('keyup', debounce((e) => {
            if (e.target.value.trim().length > 2) {

              localStorage.setItem('searched', e.target.value);
              let searchingObject = localStorage.getItem('searched') || null;

              var searchBoxs = document.querySelector('.header-search-form');
              // if (searchBoxs) {
              // var formElements = searchBoxs.querySelector('form');
              if (searchBoxs) {
                let totlaloader = document.querySelectorAll('.loadingone')?.length
                if (totlaloader == 0) {
                  searchBoxs.insertAdjacentHTML('afterend', loadingproduct);
                }

              }
              // }

              if (searchingObject !== null) {
                searchproductone(searchingObject.replace(/\s+/g, '+'));
              }

            }
            document.querySelectorAll('.search-block.m-open')?.forEach(i => {
              i.remove();
            });
          }, 300));

          function searchproductone(searchingObject) {
            fetch(`https://shopifyspeedy.com/litextension_sandbox/?product_cat=&post_type=product&s=${searchingObject}`)
              .then(response => response.text())
              .then(html => {
                let parser = new DOMParser();
                let doc = parser.parseFromString(html, 'text/html');

                let bodyContent = doc.body.querySelector('ul.products');
                if (!bodyContent) {
                  console.error('No products list found');
                  return;
                }

                let createhtml = `
        <div class="search-block m-open">
          <div class="search-block__header">Products</div>
          <div class="search-block__inner">
            <ul class="search-block__list">`;

                const productItems = bodyContent.querySelectorAll('li');
                const maxVisibleProducts = 5;

                productItems.forEach((w, index) => {
                  if (index >= maxVisibleProducts) return;

                  const name = w.querySelector('.woocommerce-loop-product__title')?.innerText.trim() || false;
                  const url = w.querySelector('.thumbnail-and-details a')?.href || '#';
                  const image = w.querySelector('.thumbnail-and-details a img')?.src || '';
                  const imageSet = w.querySelector('.thumbnail-and-details a img')?.srcset || '';
                  const price = w.querySelector('.price')?.innerHTML.trim() || 'Price not available';
                  if (name && image !== "https://shopifyspeedy.com/litextension_sandbox/wp-content/uploads/2022/07/woocommerce-placeholder-600x600.png") {
                    createhtml += `
                  <li class="search-block__item search-item">
                    <a href="${url}" class="search-item__link">
                      <div class="search-item__image">
                        <img alt="${name}" src="${image}" srcset="${imageSet}">
                      </div>
                      <div class="search-item__content">
                        <h3 class="search-item__name">${name}</h3>
                        <p class="search-item__price">
                          <span class="js-item-price-name">Your Price</span>
                          <span class="search-item__price-current">${price}</span>
                        </p>
                      </div>
                    </a>
                  </li>`;
                  }
                });

                createhtml += `</ul>`;

                if (productItems.length > maxVisibleProducts) {
                  createhtml += `
          <div class="view-all">
            <a href="https://shopifyspeedy.com/litextension_sandbox/?product_cat=&post_type=product&s=${searchingObject}">
              View All Products &rarr;
            </a>
          </div>`;
                }
                createhtml += `</div>
        </div>`;

                document.querySelectorAll('.loadingone')?.forEach(i => {
                  i.remove();
                });
                document.querySelectorAll('.search-block.m-open')?.forEach(i => {
                  i.remove();
                });

                const searchBox = document.querySelector('.header-search-form');
                if (searchBox) {
                  searchBox.insertAdjacentHTML('afterend', createhtml);

                } else {
                  console.error('No .header-search-form element found in the DOM');
                }
              })
              .catch(err => console.error('Error fetching HTML:', err));
          }

          const custom_meta_p = document.querySelector('.custom_product.product_meta.extractdetails .metaBox_content.characteristics p');
          if (custom_meta_p && (custom_meta_p.innerHTML === 'No attributes found.' || custom_meta_p.innerHTML.trim() === '')) {
            document.querySelector('.custom_product.product_meta.extractdetails').style.display = 'none';
          }


        </script>
        <script defer>
document.addEventListener("DOMContentLoaded", function () {
  const contentElement = document.querySelector(".woocommerce-MyAccount-content p");

  if (contentElement) {
    // Use a regular expression to replace everything from '(' to ')'
    contentElement.innerHTML = contentElement.innerHTML.replace(/\(.*?\)/g, '');
  }
	document.querySelector('.footer-social-icons .social-fas-fa-music.shape-square i').className = 'fab fa-tiktok';
	document.querySelector('.header-social-icons .social-fas-fa-music.shape-square i').className = 'fab fa-tiktok';
	
	document.querySelectorAll('.timer-display .flip-card').forEach((it) => {
    if (it.innerText === '00') {
        document.querySelector('.timer-section').style.display = 'none';
    }
});
});

console.log('=============App===================')
        </script>

<script>
setTimeout(function() {
  var accers = document.querySelectorAll('a');
  accers.forEach(function(accer) {
    if (
      !accer.getAttribute('href') || accer.getAttribute('href') === 'javascript:void(0)' || accer.getAttribute('href') === 'javascript:void(0);'
    ) {
      accer.setAttribute('href', 'javascript:void()'); 
    }
  });

  var images = document.querySelectorAll('img');
  images.forEach(function(image) {
    if (!image.getAttribute('loading')) {
      image.setAttribute('loading', 'eager'); 
    }
  });
}, 1000);
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const links = document.querySelectorAll("a");

    links.forEach(link => {
        // Check if the link has text content or an aria-label attribute
        const hasTextContent = link.textContent.trim().length > 0;
        const hasAriaLabel = link.hasAttribute('aria-label');

        // If the link does not have text content or an aria-label, set a default aria-label
        if (!hasTextContent && !hasAriaLabel) {
            link.setAttribute('aria-label', 'Link');
        }
    });
});
</script>

<script>   document.querySelectorAll('img:not([alt])').forEach(img => {
    img.setAttribute('alt', 'Image'); // Sets default alt text as "Image"
});
</script>

        </body>

        </html>