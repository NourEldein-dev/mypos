document.addEventListener('DOMContentLoaded', function () {
    const app = Vue.createApp({
        data() {
            return {
                products: [],    // Array to hold products
                selectedProduct: null,  // Variable to store the selected product
            };
        },
        computed: {
            total() {
                //calculate the total price 
                const sum = this.products.reduce(
                    (sum , product) => sum + product.sale_price * product.pivot.quantity , 0
                );
                //format the result of price 
                return sum.toLocaleString("en-US", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                });
            }
        },
        methods: {
            async fetchProducts(orderId) {
                // Fetch products using the API endpoint
                try{const response = await fetch(`/api/orders/${orderId}/products`);
                if(!response.ok){
                    throw new Error('Network response was not ok');
                }
                this.products = await response.json();

                this.scrollToBottom(); // Scroll to the bottom after fetching products
                console.log('Fetched products:', this.products); 
                
                } catch (error) {
                console.error('Error fetching products:', error);
                }
               
            },
            scrollToBottom() {
                // Scroll smoothly to the bottom of the page
                window.scrollTo({
                    top: document.body.scrollHeight,
                    behavior: 'smooth'
                });
            },

            printTable() {
                // Select the print button and temporarily hide it
                const printButton = document.querySelector('.print-button'); // Use the class you added
                if (printButton) {
                    printButton.style.display = 'none'; // Hide it
                }
            
                // Save the original document content
                const originalContent = document.body.innerHTML;
            
                // Get the HTML of the specific table
                const tableContent = this.$refs.printSection.innerHTML;
            
                // Set the body content to only the table
                document.body.innerHTML = tableContent;
            
                // Trigger the print dialog
                window.print();
            
                // Restore the original document content
                document.body.innerHTML = originalContent;
            
                // Restore the print button after printing
                if (printButton) {
                    printButton.style.display = 'inline-block'; // Show it again
                }
            }

        }
        
    });

    app.mount('.content-wrapper'); // Mount Vue on the main content wrapper
});
