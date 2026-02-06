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
          <input type="checkbox" class="event-checkbox">
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
      <div class="calendar-overlay pt-5">
         <div class="d-flex align-items-center justify-content-between w-100">
          <a href="edit-shift.html">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M3 17.25V21H6.75L17.81 9.94L14.06 6.19L3 17.25ZM20.71 7.04C21.1 6.65 21.1 6.02 20.71 5.63L18.37 3.29C17.98 2.9 17.35 2.9 16.96 3.29L15.13 5.12L18.88 8.87L20.71 7.04Z" fill="white"/>
</svg>

          </a>


          <button type="button" class="hover-btn"
          data-bs-toggle="modal" data-bs-target="#addModal">
          <svg width="21" height="19" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_535_18896)">
<path fill-rule="evenodd" clip-rule="evenodd" d="M0 18.1465V15.2122C1.56885 14.5132 6.37451 13.1854 6.60181 11.2645C6.65308 10.8304 5.62939 9.17779 5.39526 8.38482C4.89453 7.58501 4.71338 6.31524 5.26367 5.46929C5.48242 5.13433 5.38843 3.90899 5.38843 3.44585C5.38843 -1.15303 13.4463 -1.15474 13.4463 3.44585C13.4463 4.02861 13.313 5.09673 13.6292 5.55303C14.1572 6.31695 13.8838 7.67388 13.4395 8.38311C13.1541 9.21539 12.0671 10.7911 12.1594 11.2628C12.5046 13.0179 16.9617 14.1954 18.3647 14.8209V18.1448H0V18.1465ZM18.7886 6.17852V8.26177H21V9.83746H18.7886V12.0489H17.2129V9.83746H15.0032V8.26177H17.2146V6.05205H18.7903V6.17852H18.7886Z" fill="white"/>
</g>
<defs>
<clipPath id="clip0_535_18896">
<rect width="21" height="18.1477" fill="white"/>
</clipPath>
</defs>
</svg>

          </button>

          <div>
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M6 19C6 20.1 6.9 21 8 21H16C17.1 21 18 20.1 18 19V7H6V19ZM8 9H16V19H8V9ZM15.5 4L14.5 3H9.5L8.5 4H5V6H19V4H15.5Z" fill="white"/>
</svg>

          </div>
         </div>
      

         <button  class=" main-btn-white"
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
        start: "2023-09-20T10:00:00", // Start date and time in ISO format
        end: "2023-09-20T12:00:00", // End date and time in ISO format
        backgroundColor: "#20C9AC1A",
        borderColor: "#20C9AC",
        category: "Accounting",
      },
      {
        title: "Event 2",
        start: "2023-09-17T10:00:00",
        end: "2023-09-17T11:30:00",
        backgroundColor: "#FC34001A",
        borderColor: "#FFA043",
        category: "Finance",
      },
      {
        title: "Review data from Q1",
        start: "2023-09-18T06:00:00",
        end: "2023-09-18T08:30:00",
        backgroundColor: "#5542F61A",
        borderColor: "#5542F6",
        category: "Marketing",
      },
      {
        title: "Event 4",
        start: "2023-09-17T01:00:00",
        end: "2023-09-17T03:30:00",
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