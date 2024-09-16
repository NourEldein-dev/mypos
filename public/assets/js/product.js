document.addEventListener('DOMContentLoaded', function () {
    
    // Select all product description containers by id prefix 'app-'
    document.querySelectorAll('[id^="app-"]').forEach((element) => {
        // Get the product id by removing the 'app-' prefix
        const productId = element.id.replace('app-', '');

        // Mount Vue.js to each product description container
        Vue.createApp({
            data() {
                return {
                    description: element.getAttribute('data-description'), // Use the data-description attribute from the element
                    limit: 50,
                    showFullText: false,
                    translations: window.translations
                };
            },
            computed: {
                truncatedDescription() {
                    return this.description.length > this.limit ?
                        this.description.substring(0, this.limit) + '...' :
                        this.description;
                }
            },
            methods: {
                toggleText() {
                    this.showFullText = !this.showFullText;
                }
            }
        }).mount(`#app-${productId}`);
    });
});