(function() {
    const search = instantsearch({
        appId: "J1CIL2U9MT",
        apiKey: "2ac93aef991432373d1e67a3f4bd85df",
        indexName: "products",
        urlSync: true
    });
    search.addWidget(
        instantsearch.widgets.hits({
            container: "#hits",
            templates: {
                empty: "No results",
                item: function(item) {
                    return `
                        <a href="${window.location.origin}/product/${item.id}">
                        <div class="flex items-center">
                            <div class=" mr-10">
                                <img src="${window.location.origin}/images/backend_images/product/small/${item.image}" alt="img" class="algolia-thumb-result">
                            </div> 
                            <div class="flex flex-col">
                                <div class="text-3xl text-black-600">
                                    ${item._highlightResult.product_name.value}
                                </div>
                                <div class="text-2xl text-gray-600">
                                    ${item._highlightResult.description.value}
                                </div>
                                <div class="text-3xl text-black text-bold">
                                    € ${item.price.toFixed(2).split(".")}
                                </div>
                            </div>
                        </div>
                        </a>
                        <hr class="mb-4 mt-4"/>
                    `;
                }

                // "<em>Hit {{objectID}}</em>: {{{_highlightResult.product_name.value}}}"
            }
        })

    );


    // initialize SearchBox
    search.addWidget(
        instantsearch.widgets.searchBox({
            container: "#search-box",
            placeholder: "Recherche de produits"
        })
    );

    // initialize pagination
    search.addWidget(
        instantsearch.widgets.pagination({
            container: "#pagination",
            maxPages: 20,
            // default is to scroll to 'body', here we disable this behavior
            scrollTo: false
        })
    );

    search.addWidget(
        instantsearch.widgets.stats({
            container: "#stats-container"
        })
    );

    // initialize RefinementList
    search.addWidget(
        instantsearch.widgets.refinementList({
            container: "#refinement-list",
            attributeName: "categories",
            sortBy: ["name:asc"]
        })
    );

    search.start();
})();
