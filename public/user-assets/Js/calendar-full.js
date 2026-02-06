document.addEventListener("DOMContentLoaded", function () {
  var calendarEl = document.getElementById("calendar");
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "timeGridWeek",
    headerToolbar: {
      left: "title prev,next",
      right: "dayGridMonth,timeGridWeek,timeGridDay today",
    },
    titleFormat: {
      year: "numeric",
      month: "long",
    },
    views: {
      timeGridWeek: {
        dayHeaderFormat: { weekday: "short", day: "numeric" },
        allDaySlot: false,
      },
    },
    eventDidMount: function (info) {
      // 'info.el' is the DOM element for the event
      var eventEl = info.el;
      var eventTitle = info.event.title;
      var eventStart = info.event.startStr; // Start time in ISO format
      var eventEnd = info.event.endStr; // End time in ISO format
      var eventCategory = info.event.extendedProps.category; // Replace with your event category
      var eventBorderColor = info.event.borderColor; 
      var eventColor = info.event.backgroundColor;

      eventEl.closest(".fc-timegrid-event-harness").style.backgroundColor =
        eventColor;
        

      // Assuming eventStart and eventEnd are ISO date strings, e.g., "2023-09-20T10:00:00"
      const startTime = new Date(eventStart);
      const endTime = new Date(eventEnd);

      // Function to format a date as HH:mm (hours and minutes)
      function formatTime(date) {
        const hours = date.getHours().toString().padStart(2, "0");
        const minutes = date.getMinutes().toString().padStart(2, "0");
        return `${hours}:${minutes}`;
      }

      // Format start and end times
      const formattedStartTime = formatTime(startTime);
      const formattedEndTime = formatTime(endTime);

      // Create HTML content
      var htmlContent = `
      <div class="event-border"></div>
      <div class="event-details">
        <div class="event-header">
         
          <img src="assets/images/mark.svg" class="ms-auto"/>
        </div>
        <div class="event-time">
          <span>${formattedStartTime} - ${formattedEndTime}</span>
        </div>
        <div class="event-title">
          <strong>${eventTitle}</strong>
        </div>
        <div class="event-category">
          <span>${eventCategory}</span>
        </div>
      </div>
      <div class="calendar-overlay ">

      <a href="clock-time.html"  class="main-btn-white w-100">Clock Time</a>

         <button  class=" main-btn-white w-100 mt-2"
         data-bs-toggle="modal" data-bs-target="#event-details">Details</button>
      </div>
      
    `;

      // Set the innerHTML of the event element to display HTML content
      eventEl.innerHTML = htmlContent;

      eventEl.querySelector(".event-border").style.backgroundColor =
        eventBorderColor;
    },
    events: [
      {
        title: "Event 1",
        start: "2023-11-20T10:00:00", // Start date and time in ISO format
        end: "2023-11-20T12:00:00", // End date and time in ISO format
        backgroundColor: "#20C9AC1A",
        borderColor: "#20C9AC",
        category: "Accounting",
      },
      {
        title: "Event 2",
        start: "2023-11-12T10:00:00",
        end: "2023-11-12T11:30:00",
        backgroundColor: "#FC34001A",
        borderColor: "#FFA043",
        category: "Finance",
      },
      {
        title: "Review data from Q1",
        start: "2023-11-14T06:00:00",
        end: "2023-11-14T08:30:00",
        backgroundColor: "#5542F61A",
        borderColor: "#5542F6",
        category: "Marketing",
      },
      {
        title: "Event 4",
        start: "2023-11-17T01:00:00",
        end: "2023-11-17T03:30:00",
        backgroundColor: "#20C9AC1A",
        borderColor: "#20C9AC",
        category: "IT Support",
      },
      // Add more event objects as needed
    ],
  });
  calendar.render();
});
// $('body').on('click','.event-title',function(){
//  $(this).closest.$('.calendar-overlay').css('display','flex');
// })

  // // Add click event handler to all .event-title elements
  // $('body').on('click','.event-title',function() {
  // // Find the closest .event-details parent element
  //     $('.event-title').closest('.calendar-overlay').css('display','flex');

  // });