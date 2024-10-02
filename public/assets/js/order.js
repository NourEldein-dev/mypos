document.addEventListener("DOMContentLoaded", function () {

    const appElement = document.getElementById('order-app');


    const app = Vue.createApp({
        data() {
            return {
                orders: [], 
                openedCategory: null,
                openedOrder: null,
            };
        },
        computed: {
            total() {
                //calculate the total price 
                const sum = this.orders.reduce(
                    (sum, order) => sum + order.sale_price * order.quantity , 0
                );
                const validSum = sum <= 0 ? 0 : sum;
                //format the result of price 
                return validSum.toLocaleString("en-US", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                });
            },
        },
        methods: {
            toggleCategory(categoryId) {
                this.openedCategory = 
                this.openedCategory === categoryId ? null : categoryId;
            },

            toggleOrder(orderId) {
                this.openedOrder =
                this.openedOrder === orderId ? null : orderId;
            },

            addProduct(product) {
                // Get the product from the order if it already exists
                const existingOrder = this.orders.find(order => order.id === product.id);
                
                // Handle the situation for editing: Calculate the remaining stock based on what's in the order
                let remainingStock = product.stock;
            
                // If the product is already in the order, subtract its current order quantity from the stock
                if (existingOrder) {
                    remainingStock -= existingOrder.quantity;
                }
            
                // Check if there is enough stock to add the product
                if (remainingStock > 0) {
                    if (existingOrder) {
                        // If the product is already in the order, increase the quantity
                        if (existingOrder.quantity < product.stock) {
                            existingOrder.quantity++;
                        } else {
                            alert('Cannot add more than the available stock.');
                        }
                    } else {
                        // If the product isn't already in the order, add it with a quantity of 1
                        this.orders.push({
                            id: product.id,
                            name: product.name,
                            quantity: 1,
                            sale_price: product.sale_price,
                            stock: product.stock // Keep track of original stock
                        });
                    }
                } else {
                    // No stock available
                    alert('This product is out of stock or exceeds the remaining stock.');
                }
            },

            updateQuantity(product) {
                const existingOrder = this.orders.find(order => order.id === product.id);
                if (existingOrder && existingOrder.quantity > product.stock) {
                    existingOrder.quantity = product.stock; // Limit the quantity to available stock
                }
            },

            calculateRemainingStock(product) {
                const existingOrder = this.orders.find(order => order.id === product.id);
                let remainingStock = product.stock;
        
                if (existingOrder) {
                    remainingStock -= existingOrder.quantity;
                }
        
                return remainingStock;
            },
        
            
            removeOrder(index) {
                const order = this.orders[index];
                if (order.quantity > 1) {
                    order.quantity--;
                } else {
                    this.orders.splice(index, 1);
                }
            },
            autoRemoveOrder(index){
                const order = this.orders[index];
                if(order.quantity < 1) {
                    this.orders.splice(index, 1);
                }
            },
                
            checkInput(event, order) {
                const inputValue = parseInt(event.target.value); // Get the input value as a number
                
                // Ensure the quantity doesn't go below 0
                if (inputValue < 0) {
                    event.target.value = 0;
                    order.quantity = 0;
                }
        
                // Ensure the quantity doesn't exceed the stock
                if (inputValue > order.stock) {
                    event.target.value = order.stock; // Set the input back to the stock limit
                    order.quantity = order.stock;
                } else {
                    order.quantity = inputValue; // Set the input if it's within the valid range
                }
            },



            // Transition hooks for smooth category collapse
            beforeEnter(el) {
                el.style.height = "0";
                el.style.opacity = "0";
                el.style.overflow = "hidden"; // Ensure no content is shown during transition
            },
            enter(el, done) {
                const height = el.scrollHeight;
                el.style.transition = "all 0.3s ease";
                el.style.height = height + "px";
                el.style.opacity = "1";
                el.style.overflow = "hidden"; // Ensure smooth transition without overflow
                el.addEventListener("transitionend", done);
            },
            leave(el, done) {
                el.style.transition = "all 0.3s ease";
                el.style.height = "0";
                el.style.opacity = "0";
                el.style.overflow = "hidden"; // Hide content during the collapse
                el.addEventListener("transitionend", done);
            },

            //get the products
            async fetchProducts(orderId){
                try{
                    const response = await fetch(`/api/clients/orders/${orderId}/products`);
                    if(!response.ok){
                        throw new Error('Network response was not ok');
                    }
                    this.orders = await response.json();
                    console.log('Fetched orders:', this.orders);
                }catch(error){
                    console.error('Error fetching products:', error);
                }
            },

        },
        mounted() {
            const orderId = appElement.getAttribute('data-order-id');
            this.fetchProducts(orderId);
        }
    });

    app.mount("#order-app");
});
