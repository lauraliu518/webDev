# JavaScript Language Fundamentals  
---
#### JavaScript placement:   
- in body before closing tag  
- inline tags: `<img>, <br>`

#### Generating output with JavaScript (console.log, document.write, alert, prompt, etc)
- `console.log();` prints to console
- `document.write(<h1>hello</h1>);` directly write html
- `alert("Hello! I am an alert box!!");` pop up alert
- `userEntered = prompt("text for display");` returning user input content, type preserved  

#### Variable declaration (let / var / const)
- `var element1;` scoped to function, if outside of function, global
- `let element2;` scoped to block of exec, 
- `const element3;` read only

#### Object
    let myObj = {
        name: 'Pikachu',
        age: 6,
        powers: ['thunder', 'shock']
    };
- Referencing properties: `myObj.prop`
- Modify/Add properties: `myObj.prop = newVal`
- Add methods: `myObj.funcName = function(){}`

#### Array
- Modify Array:
    - `arr.push()`
    - `arr.splice(startIdx,count)`
- Iteration: 
    - `for(let idx in arr)` iterate over INDEX, use `arr[idx]`
    - `for(let item of arr)` iterate over ELEMENT, use `item`, idx omitted

#### Syntaxes
- Casting: `parseInt()`, `parseFloat()`, `.toString` / `3+'3'`
- Using variables in CSS/HTML: `` `${varName}` ``

# DOM
---

#### Getting References
- `querySelector()`
- `querySelectorAll()`
- `getElementById()`
- `getElementsByClassName()`
- `getElementsByTagName()`

#### Attributes
- Styles
    - Background Color: `.style.backgroundColor`
    - Text Color: `.style.color`
    - Font: `.style.fontFamily`
    - Font-Size: `.style.fontSize` (cautious with units)
    - Hide/Show: `.style.display`
    - Top, bottom, left, right: `style.top/bottom/left/right = "3px"` (UNITS!!!!)
    - Include border: `.style.boxSizing: "border-box";` or in CSS `box-sizing: border-box;`
- Common Attributes
    - HTML Content: `.innerText`  
        <i>Note: use `el.innerText +=` to append.</i>
    - Image Element (`<img>`) Image: `element.src = "path/name.format";`
    - Div Element Image: `element.backgroundImage = "url('path/name.format')";`   
        <i>Note: Double quote around entire expression, single quote/`` for path. </i>
- Check attribute availbility
    - `element.hasAttribute("tag")` check direct html attribute
    - check style attribute
        ```
        let a = document.getElementById('foo');
        let allStyles = window.getComputedStyles(a);
        if (allStyles.color !== undefined) {
            // it's safe to work with the color 
        }
        ```

#### Class Membership
- `.classList.contains("className")` returns TF
- `.classList.add("elementRef")`
- `.classList.remove("elementRef")`

# Element-level Manipulation
---

#### Creation and Placement
- `document.createElement("tagName")`
- `parent.appendChild(el)` add as the last element
- `.insertBefore( elementToAdd, elementForLocRef )` two arguments: the element you are inserting and the element that it should go before
    - `theDiv.insertBefore( newP2, theDiv.firstElementChild );` add newP2 as first element
    - To add to nth position: `parent.insertBefore( newElement, parent.children[n-1] );` Add to second use `children[1]`
- `.insertAfter( elementToAdd, elementForLocRef )`
#### Removal
- `el.remove();`
- `parent.removeChild(childRef);`
#### Pointers
- Parent
    - `.parentElement` returns `null` w/o p
- Sibling
    - `.previousElementSibling` one directly before
    - `.nextElementSibling` one directly after
- Child
    - `.firstElementChild`
    - `.lastElementChild`
    - `.children` returns array
        - `.children.length`
        - `.children[0]`

# Events
---
#### Mouse Events
- Mouse Click: `.onclick() = function(event){}` 
- Mouse Over: `.onmouseover() = function(event){}` 
- Mouse Out: `.onmouseout() = function(event){}` 
#### Propagation and Default
- `event.stopPropagation();` 
    - stops bubbling to parent listeners (only for the specific event)
    - put this in the level that should be listening for the last (inclusive placement)
- `event.preventDefault()`
    - stop normal action of program
    - put in form to prevent refreshing

# Form & UI
---

#### Basic Structure
#### Form
- `<form></form>`
- use `event.preventDefault()` to avoid browser's constant storing

#### Text Boxes
- `<input></input>`
- Attributes
    - `type="text"` allows strings
    - `name="val"` server communication, may reuse id name
    - `id="val"`
    - `value="default"` message to display in empty text box
    - `maxlength="10` constrain length
- Access
    - only access when button on click, else may result in empty string
    - reference `<input>` and use `.value` (no parenthesis)
    - `result = myInput.value`
- Structure
    ```
    <label for="myText">Title:</label>
    <input type="text" id="myText">
    ```
Textboxes are inline elements, horizontal alignment.

#### Text Areas
- `<textarea></textarea>`
- Attributes
    - `type="text"` allows strings
    - `name="val"` server communication, may reuse id name
    - `id="val"`
    - `value="default"` message to display in empty text box
    - `maxlength="10` constrain length
- Access
    - only access when button on click, else may result in empty string
    - reference `<textarea>` and use `.value` (no parenthesis)
    - `result = myTextarea.value`
    - Use CSS `width` and `height` to adjust size

#### Drop-Down Menus
- Structure
    ```
    <select name="food" id="food">
        <option value="pizza">I like pizza!</option>
        <option value="cake">I like cake!</option>
    </select>
    ```
    - `<select>` holds `id="idname`
    - `<options>` holds `value="val"`
- Access
    - `selectReference.value`

#### Check-Boxes
- Structure
    ```
    <input type="checkbox" class="color" value="red" name="red" id="red">Red
    <input type="checkbox" class="color" value="green" name="green" id="blue">Green
    <input type="checkbox" class="color" value="blue" name="blue" id="blue">Blue
    
    <button id="button">Click to access the check boxes</button>

    <script>
    const colorCheckboxes = document.querySelectorAll('.color');
    const output = document.querySelector('#output');
    document.querySelector('#button').onclick = function(event) {
        for (let el of colorCheckboxes) {
            if (el.checked) {
                //use el.value
            }
        }
    }
    </script>
    ```
- Access
    - `el.value` to access box value
    - `el.checked` to access if box is checked


# Timing Functions
---

#### `setInterval()`
- Structure:
    ```
    setInterval(function, delaytime);
    ```
- Function:
    - ananomous: 
        - `setInterval(function(){}, delaytime);`
    - explicit:
        - `setInterval(funcName, delaytime);` (Note: Do not include parenthesis of funcName to avoid calling)
- Delay Time:
    - in milliseconds
- Return Type: intervalId. May be stored to end interval
- End Interval
    - Use `clearInterval(intervalID)` to stop a specific interval

#### `setTimeout()`
- `setTimeout(function, delayTime)` runs once
# Dataset
---
- in HTML
    - use `data-category="content"` within tag
    - Example: `<img src="dog2.jpg" data-species="poodle">`
- in Js
    - use `element.dataset.category` after referencing element
    - no special characters

# Local Storage
---
#### Set Data
- `localStorage.setItem(key, value)`

#### Get Data
- `localStorage.getItem(key)` 
- Returns `null` if doesnt exist

#### Remove Data
- `localStorage.removeItem(key)`

#### Clear All Local Storage
- `localStorage.clear()`

# Handy Functions
---

#### Random Color
```
    function randColor(){
        let r = parseInt(Math.random()*255);
        let g = parseInt(Math.random()*255);
        let b = parseInt(Math.random()*255);
        color = `rgb(${r},${g},${b})`;
        return color;
    }
    myelement.style.backgroundColor = randColor();
```

#### Set Interval with End All Previous Intervals
 ```
    let intervalId = undefined;

    element.someevent = function() {
        clearInterval( intervalId );
        intervalId = setInterval( function() {
            //some action        
        }, 500); 
    }
```

#### Error Template
    
    <div id="errorEmptyString">
        Fill It In!
    </div>

    function exist(input){
        for (item of existingItems){
            if(input === item){
                return false;
            }
        }
        return true;
    }
    


#### Time Generation
    
    function getTime(){
        let time = new Date();
        result = time.toLocaleDataString();
        result += time.toLocaleTimeString();
        return result;
    }
    

#### Randomly pick 5 (Allow Repeat)
    
    let results = [];
    for(let i = 0; i < 5; i ++){
        let idx = parseInt(Math.random()*myArr.length);
        result.push(myArr[idx]);
    }
    
#### Randomly pick 5 (no repeat)
    
    let results = [];
    for(let i = 0; i < 5; i ++){
        let idx = parseInt(Math.random()*myArr.length);
        result.push(myArr[idx]);
        myArray.splice(idx, 1);
    }
    
### Time W Placeholder
        let time = new Date();
        let hour = time.getHours();
        let min = time.getMinutes();
        let apm;
        if(0 <= hour && hour < 6){
            apm = "am";
        }else if(6 <= hour && hour < 12){
            apm = "am";
        }else if(12 <= hour && hour < 18){
            apm = "pm";
            hour -= 12;
        }else if(18 <= hour && hour < 24){
            apm = "pm";
            hour = hour - 12;
        }
        //add placeholder 0 
        if(hour < 10){
            hour = "0" + hour;
        }
        if(min < 10){
            min = "0" + min;
        }


# PHP
    ```
    <?php
        echo "something";
        print "something";
        $name = 'pikachu';
        print "my name is $name";
        print rand(1,10);
        

        if(){

        }else(){

        }

        for( $i = 0; $i < 10; $i++){

        }
    
    ?>