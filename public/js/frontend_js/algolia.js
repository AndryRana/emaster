(function() {
    var client = algoliasearch('J1CIL2U9MT', '2ac93aef991432373d1e67a3f4bd85df');
    var index = client.initIndex('products');
    var enterPressed = false;
    //initialize autocomplete on search input (ID selector must match)
    autocomplete('#aa-search-input',
        { hint: false }, {
            source: autocomplete.sources.hits(index, { hitsPerPage: 10 }),
            //value to be displayed in input control after user's suggestion selection
            displayKey: 'name',
            //hash of templates used when rendering dataset
            templates: {
                //'suggestion' templating function used to render a single suggestion
                suggestion: function (suggestion) {
                    const markup = `
                        <div class="algolia-result">
                            <span>
                                <img src="${window.location.origin}/images/backend_images/product/small/${suggestion.image}" alt="img" class="algolia-thumb">
                                ${suggestion._highlightResult.product_name.value}
                            </span>
                            <span>€${((suggestion.price).toFixed(2)).split(".")} </span>
                        </div>
                        <div class="algolia-details">
                            <span>${suggestion._highlightResult.description.value}</span>
                        </div>
                    `;
                    return markup;
                    // return '<span>' + 
                    // suggestion._highlightResult.product_name.value + '<span></span>' +
                    // suggestion.price + '</span>';
                },
                empty: function (result) {
                   return 'Aucun résultat pour "' + result.query + '"';
                }
            }
        }).on('autocomplete:selected',function (event, suggestion, dataset){
            window.location.href = window.location.origin + '/product/' + suggestion.id;
            enterPressed = true;
        }).on('keyup', function(event){
            if (event.keyCode == 13 && !enterPressed) {
                // alert('Enter pressed');
                window.location.href = window.location.origin + '/search-high-product?q=' + document.getElementById('aa-search-input').value;
            }
        });
})();