import React, { useState, useEffect } from 'react';
import './index.css'

//All the comments in this starter code are suggestions, feel free to discard them.

const App = () => {

  //use 'useState' to create variables for the temperature value and the color of the thermostat
  const [temp, setTemp] = useState(70);
  const [color, setColor] = useState("primary");
  


  //code a function for how the color and numbers in the thermostat should be chnaged when the temperature is increased
  const increaseTemp = () => {
    setTemp((prevTemp) => prevTemp + 1);
    if(temp > 70){
      setColor((color) => "secondary");
    } else if (temp < 70){
      setColor((color) => "third");
    } else if (temp === 70){
      setColor((color) => "primary");
    }
  };

  //code a function for how the thermostat should chnage when the temperature is decreased
  const decreaseTemp = () => {
    setTemp(
      (prevTemp) => prevTemp - 1
    );
    if(temp > 70){
      setColor((color) => "secondary");
    } else if (temp < 70){
      setColor((color) => "third");
    } else if (temp === 70){
      setColor((color) => "primary");
    }
  };

  const name = null;
  const isUserLogged = true;
  //Component - code that returns or renders jsx

  useEffect(() => {
    setTemp(70);
    //alert(" Youve changed temp to " + temp);
}, []);

//to switch colors simply need to use props!

//Put what you want to see on the webpage inside return. Use <div> and <button> tags.
  return (

    <div className="App">
      <div class="temp">
      <div class="temp-circle">
      <div class="range slider">
      <div class={color}>
      <div class="circle2">
      <div class="circle3">
            <h1>{temp} °</h1>
      </div>
      </div>
      </div>
      </div>
      <div className="buttonSet">
          <button className = "button" onClick={() => decreaseTemp()}> - </button>
          <>&nbsp;&nbsp;</>
          <button className = "button" onClick={() => increaseTemp()}> + </button>
        </div>
      </div>
      </div>
    </div>
    
  );
}; 

/**<div class="temp">
      <div class="temp-circle">
        <div class="range slider">
          <div class="circle1">
            <div class="circle2">
              <div class="circle3">
                <div class="circle4">
                  00<span>.0</span>
                  <strong>&deg;</strong>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class='buttonSet'>
          <div class ="button">
                +
          </div>
          <div class ="button">
              -
          </div>
        </div>
    </div> */

export default App;
