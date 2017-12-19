/* create new cart object, if you refresh the website */
window.onload = function () {
    window.cart = new ShoppingCart();
};

var address_invalid = "Bitte geben Sie eine gültige Lieferadresse ein!";
var pizza_missing = "Der Warenkorb muss mindestens eine Pizza enthalten!";
var pizza_amount = "Es dürfen maximal 20 Pizzen einer Sorte bestellt werden!";

function ShoppingCart() {
    "use strict";
    
    var pizzas = [];
    /* reference of cart */
    var ordersElement = document.getElementById("orders");
    /* reference of formular */
    var form = document.getElementById("order_form");
    /* reference of total price */
    var sumElement = document.getElementById("sum");
    /* reference of address */
    var addressElement = document.getElementById("address");
    /* add pizza name and price to the cart */

    this.addPizza = function (id) {

        // check if pizza already exists
        var pizza_tag = document.getElementById(id); 
        var name_pizza = String(pizza_tag.name);
        var pizza_object = findPizzaObjectByName(name_pizza);
        var price = parseFloat(pizza_tag.dataset.price);
        price.toFixed(2);
        if (pizza_object === null) {
            pizzas.push({name: name_pizza, price: price, count: 1}); // add new pizza
        } else {
            if(pizza_object.count < 20)
                pizza_object.count += 1; // increase number of pizza
            else   // more than 20 pizzas in shopping cart
                alert(pizza_amount);
        }
        updateDOM();
    };

    /* search pizza object in array */
    function findPizzaObjectByName(name) {
        "use strict";

        for (var i = 0; i < pizzas.length; i++) {
            if (pizzas[i].name == name) {
                return pizzas[i];
            }
        }
        return null;
    }

    /* find selected pizza*/ 
    function findSelectedPizza() {
        "use strict";

        var used_indizes = [];
        for (var position = 0; position < ordersElement.options.length; position++) {
            var option = ordersElement.options[position];
            if (option.selected)
                used_indizes.push(position);
        }
        return used_indizes;
    }

    /* delete marked pizza */
    this.removePizza = function () {
        "use strict";

        var used_indizes = findSelectedPizza();

        var position = 0;
        while (position < used_indizes.length){
            var index = used_indizes[position];
            var option = ordersElement.options[index];
            var obj = JSON.parse(option.value);
            var pizza = findPizzaObjectByName(obj.name);
            if (pizza.count > 1) {
                pizza.count -= 1;
                option.selected = true;
                position++;
            } else {
                var elemIndex = pizzas.indexOf(pizza);
                pizzas.splice(elemIndex, 1);   // delete selected pizza from pizzas[]
                used_indizes.splice(position, 1);
            }
        }
        updateDOM();
    };

    /* delete whole cart */
    this.reset = function () {
        "use strict";

        pizzas = [];
        updateDOM();
    };

    /* send cart to the server, if all inputs correct */
    this.submit = function () {
        "use strict";

        var actualAddress = String(addressElement.value);

        if (!selectedPizza()){
            alert(pizza_missing);
            return false;
        }

        if (ValidAddress(actualAddress)) {
            updateDOM(); // render again
            selectEachOptionInDom();
            
            form.submit();
            return true;
        }else{
            alert(address_invalid);
            return false;
        }
    };

    function selectedPizza(){
        "use strict";

        return pizzas.length > 0;
    }

    function ValidAddress(actualAddress){
        "use strict";

        return actualAddress !== undefined && actualAddress !== null && actualAddress.trim().length > 0;   // trim() method removes whitespace from both side of a string 
    }

    /* set each element to marked */
    function selectEachOptionInDom() {
        "use strict";

        var i;
        var option;
        for (i = 0; i < ordersElement.options.length; i+=1) {
            option = ordersElement.options[i];
            option.selected = true;
        } 
    }

    /* clone json object */
    function cloneObject(obj) {
        "use strict";

        return JSON.parse(objToString(obj));
    }

    /* convert json in string */
    function objToString(obj) {
        "use strict";

        return JSON.stringify(obj);
    }

    /* update DOM with informations of the cart */
    function updateDOM() {
        "use strict";

        resetOrderListInDOM();
        var option;
        for (var position = 0; position < pizzas.length; position+=1) {
            option = createPizzaOptionElement(pizzas[position]);
            ordersElement.add(option);
        }
        var price = calculateTotalPrice();
        updatePriceInDOM(price);
    }

    /* number and name of pizza */
    function createPizzaOptionElement(pizza){
        "use strict";

        // create option element
        var option = document.createElement("option");
        
        option.text = pizza.count + "x " + pizza.name;
        var obj = cloneObject(pizza);  
        delete obj.price;    
        option.value = objToString(obj);
        return option;
    }

    /* set price in DOM */
    function updatePriceInDOM(totalPrice){
        "use strict";

        sumElement.removeChild(sumElement.firstChild);
        var new_price = document.createTextNode(totalPrice);
        sumElement.appendChild(new_price);
    }

    /* delete all elements */
    function resetOrderListInDOM() {
        "use strict";

        // if a valid child element exists 
        while (ordersElement.firstChild) {
            // remove this element
            ordersElement.removeChild(ordersElement.firstChild);
        }
    }

    /* calculate the price of the cart */
    function calculateTotalPrice() {
        "use strict";

        var totalPrice = 0.0;
        for (var position = 0; position < pizzas.length; position+=1) {
            var pizza = pizzas[position];
            // number of selected pizza * price, e.g. 3x Margherita
            totalPrice += pizza.count * pizza.price;
        }
        totalPrice = totalPrice.toLocaleString('de-GER', {minimumFractionDigits: 2});
        return totalPrice;
    }
}