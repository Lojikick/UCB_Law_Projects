function alertButton(){
    alert("Hello World");
}


let nav = 0;
////How to keep track of our current month
//Prev month? December
let clicked = null;
//Track which day we clicked
let events = localStorage.getItem('events') ? JSON.parse(localStorage.getItem('events')):[];
//Pull from local storage, belive we can use SQL otherwise
const calendar = document.getElementById('calendar');


//Const for new event modal
const newEventModal = document.getElementById('myModal');
//const backDrop = document.getElementById('modalBackDrop');
const deleteEventModal = document.getElementById('deleteModal');
const eventTitleInput = document.getElementById('eventTitleInput');

const weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];


//Wanna get a date object, get info abt the calendar so we can display it
function openModal(date) {
    clicked = date;

    const eventForDay = events.find(e => e.date == clicked); //Uses local storafe

    if (eventForDay){
        console.log('Event already exists');
        document.getElementById('eventText').innerText = eventForDay.title;
        deleteEventModal.style.display = 'block';
    }else{
        newEventModal.style.display = 'block';
    }

}
//Reusable logic, load function displays the calendar
function load() {
    //Init Date Object with methids and properties!
    const dt = new Date();


    //Nav determines if we're going forward or backward, and sets month
    // Lets say were in jan, nav-- = December, nav ++ == Febuary
    if (nav !==0){
        dt.setMonth(new Date().getMonth() + nav);
    }


    //Sets the day, month, and year
    const day = dt.getDate();
    const month = dt.getMonth();
    const year = dt.getFullYear();

    const firstDayOfMonth = new Date(year, month, 1);
    //by giving 0, first day of prev month
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    //Lets say its january, if we want last date of january, we get the zeoth day of febuary(not zero indexed), which is the last day of jan!


    const dateString = firstDayOfMonth.toLocaleDateString('en-us', {
        weekday: 'long',
        year: 'numeric',
        month: 'numeric',
        day: 'numeric',
    });
    //console.log();
    //Months are actually Zzero indexed!
    //How many days are there in the month?
        //Some months can have 31 days while some can have 30
    //console.log(dateString);
    //Logic to get the padding dattes
    //The Date string is Now an array of two items, passing in Friday into the weekdays list
    const paddingDays = weekdays.indexOf(dateString.split(', ')[0]);


    document.getElementById('monthDisplay').innerText = `${dt.toLocaleDateString('en-us', {month: 'long'})} ${year}`;
    //So the number of padding days will just be the day that the month starts at!



    //Now I can loop through all padding days and the days of the month, that wraps down to the grid:


    //Clears previous board
    calendar.innerHTML = '';


    //Renders the padding days and month
    for(let i = 1; i <= paddingDays + daysInMonth; i++){
        const daySquare = document.createElement('div');
        daySquare.classList.add('day');

        const dayString = `${month + 1}/${i - paddingDays}/${year}`;
        if (i > paddingDays) {
           // Render Day square
           daySquare.innerText = i - paddingDays;

           const eventForDay = events.find(e => e.date === dayString);
            
           if (i - paddingDays === day && nav === 0) {
                daySquare.classList.add('currentDay');
           }

           if (eventForDay) {
                const eventDiv = document.createElement('div');
                eventDiv.classList.add('event');
                eventDiv.innerText = eventForDay.title;
                daySquare.appendChild(eventDiv);
           }
           //Event listener for when the user clicks on a day, call a fucntion whenever this happens
           daySquare.addEventListener('click', () => openModal(dayString));
        } else {
             //Render Padding Day
            daySquare.classList.add('padding');
        }


        calendar.appendChild(daySquare);
    };

}

function closeModal() {
    eventTitleInput.classList.remove('error');
    newEventModal.style.display = 'none';
    deleteEventModal.style.display = 'none';
    eventTitleInput.value = '';
    clicked = null;
    load();
}

function saveEvent() {
    if (eventTitleInput.value){
        eventTitleInput.classList.remove('error');
        events.push({
            date: clicked,
            title: eventTitleInput.value,
        });
        localStorage.setItem('events', JSON.stringify(events)); //Local storafe
        closeModal();
    } else {
        eventTitleInput.classList.add('error');
    }
}

function deleteEvent() {
    events = events.filter(e => e.date !== clicked);
    localStorage.setItem('events', JSON.stringify(events));
    closeModal();
}

function initButtons(){
    //Create event listeners on my back/front buttons that updates board
    document.getElementById('nextButton').addEventListener('click', () => {
        nav++;
        load();
    });


    document.getElementById('backButton').addEventListener('click', () => {
        nav--;
        load();
    });

    document.getElementById('saveButton').addEventListener('click', saveEvent);
    document.getElementById('cancelButton').addEventListener('click', closeModal);

    document.getElementById('deleteButton').addEventListener('click', deleteEvent);
    document.getElementById('closeButton').addEventListener('click', closeModal);

}


initButtons();
load();




function makeSchedule(){
    let sleep_time = document.getElementById("sleep").value;
    let wake_time = document.getElementById("wake").value;
    start = ""
    ret_val = start.concat("Your average Sleep time is ", sleep_time, " and your average Wake time is " , wake_time, ".")
    alert(ret_val);
}


function day(number) {
    this.number = number
}

//Test modal functions

var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("butt");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 


//Object: Day:
//attr: Day_number
//attr: Task_1
//attr: Task_2
//attr: Task_3
