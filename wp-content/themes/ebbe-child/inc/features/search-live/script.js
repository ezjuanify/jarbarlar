jQuery(function ($) {
    
    function debounce(func, delay) {
        let timeout_id;
        return function () {
            const args = arguments;
            clearTimeout(timeout_id);
            timeout_id = setTimeout(() => func.apply(this, args), delay);
        };
    }

    function createLoader() {
        const wrapper = document.createElement('div');
        wrapper.id = 'loaderjs';
        wrapper.classList.add('loadingone');
        return wrapper;
    }

    function createProductItem(item) {
        const li = document.createElement('li');
        li.classList.add('search-block__item', 'search-item');

        const a = document.createElement('a');
        a.classList.add('search-item__link');
        a.href = item.url;
        
        const img_wrap = document.createElement('div');
        img_wrap.classList.add('search-item__image');

        const img = document.createElement('img');
        img.src = item.image;
        img.srcset = item.srcset;
        img.alt = item.name;
        img_wrap.appendChild(img);

        const content = document.createElement('div');
        content.classList.add('search-item__content');

        const name = document.createElement('h3');
        name.classList.add('search-item__name');
        name.textContent = item.name;

        const price_wrap = document.createElement('p');
        price_wrap.classList.add('search-item__price');

        const label = document.createElement('span');
        label.classList.add('js-item-price-name');
        label.textContent = 'Your Price';

        const price = document.createElement('span');
        price.classList.add('search-item__price-current');
        price.innerHTML = item.price;

        price_wrap.appendChild(label);
        price_wrap.appendChild(price);

        content.appendChild(name);
        content.appendChild(price_wrap);

        a.appendChild(img_wrap);
        a.appendChild(content);
        li.appendChild(a);

        return li;
    }

    function renderSearchResults(products, query, search_form) {
        $('.loadingone').remove();
        $('.search-block.m-open').remove();

        const block = document.createElement('div');
        block.classList.add('search-block', 'm-open');

        const header = document.createElement('div');
        header.classList.add('search-block__header');
        header.textContent = 'Products';

        const inner = document.createElement('div');
        inner.classList.add('search-block__inner');

        const ul = document.createElement('ul');
        ul.classList.add('search-block__list');

        products.forEach(p => ul.appendChild(createProductItem(p)));

        inner.appendChild(ul);

        if (products.length === 5) {
            const view_all = document.createElement('div');
            view_all.classList.add('view-all');

            const link = document.createElement('a');
            link.href = `https://shopifyspeedy.com/litextension_sandbox/?product_cat=&post_type=product&s=${query}`;
            link.textContent = 'View All Products →';

            view_all.appendChild(link);
            inner.appendChild(view_all);
        }

        block.appendChild(header);
        block.appendChild(inner);

        search_form.after(block);
    }

    function fetchSearch(query, search_form) {
        fetch(`https://shopifyspeedy.com/litextension_sandbox/?product_cat=&post_type=product&s=${query}`)
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                const ul = doc.querySelector('ul.products');
                if (!ul) return;

                const nodes = ul.querySelectorAll('li');
                const products = [];
                const max = 5;

                nodes.forEach((node, idx) => {
                    if (idx >= max) return;

                    const name = node.querySelector('.woocommerce-loop-product__title')?.innerHTML.trim();
                    const url = node.querySelector('.thumbnail-and-details a')?.href || '#';
                    const img = node.querySelector('img');
                    const price = node.querySelector('.price')?.innerHTML.trim() || '';

                    if (!name || !img) return;

                    products.push({
                        name: name,
                        url: url,
                        image: img.src || '',
                        srcset: img.srcset || '',
                        price: price
                    });
                });

                renderSearchResults(products, query, search_form);
            })
            .catch(err => console.error('Search Error:', err));
    }

    const search_field = document.querySelector('.search-field');
    const search_form = document.querySelector('.header-search-form');

    if (!search_field || !search_form) return;

    search_field.addEventListener('keyup', debounce(function (e) {
        const value = e.target.value.trim();
        $('.search-block.m-open').remove();

        if (value.length <= 2) return;

        localStorage.setItem('searched', value);

        if (!$('.loadingone').length) {
            search_field.after(createLoader());
        }

        fetchSearch(value.replace(/\s+/g, '+'), search_form);
    }, 300));
});