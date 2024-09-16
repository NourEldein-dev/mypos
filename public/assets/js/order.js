


document.addEventListener('DOMContentLoaded', function() {
    const app = Vue.createApp({
        data() {
            return {
                orders: [],
                openedCategory: null
            };
        },
        computed: {
            total() {
                return this.orders.reduce((sum, order) => sum + order.sale_price * order.quantity, 0);
            }
        },
        methods: {
            toggleCategory(categoryId) {
                this.openedCategory = this.openedCategory === categoryId ? null : categoryId;
            },
            addProduct(product) {
                const existingOrder = this.orders.find(order => order.product.id === product.id);
                if (existingOrder) {
                    existingOrder.quantity++;
                } else {
                    this.orders.push({
                        product: product,
                        quantity: 1,
                        sale_price: product.sale_price
                    });
                }
            },
            removeOrder(index) {
                const order = this.orders[index];
                if (order.quantity > 1) {
                    order.quantity--; // Decrease quantity if more than 1
                } else {
                    this.orders.splice(index, 1); // Remove the order if quantity is 1
                }
            },
            addOrder() {
                alert('Order added!');
            },
        }
    });

    app.mount('#order-app');
});