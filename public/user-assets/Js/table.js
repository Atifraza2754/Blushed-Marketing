const table = $("#example").DataTable({
    responsive: true,
    language: {
      searchPlaceholder: "Search records",
    },
  });
  const exampleinprogress = $("#example-inprogress").DataTable({
    responsive: true,
    language: {
      searchPlaceholder: "Search records",
    },
  });
  const tableFailed = $("#example-failed").DataTable({
    responsive: true,
    language: {
      searchPlaceholder: "Search records",
    },
  });
  const exampleQualify = $("#example-qualify").DataTable({
    responsive: true,
    language: {
      searchPlaceholder: "Search records",
    },
  });
  const upcomingTable = $("#upcoming-table").DataTable({
    responsive: true,
    searching: false,
    paging: false,
    info: false,
  });
  
  const exampleRecurring = $("#example-recurring").DataTable({
    responsive: true,
    language: {
      searchPlaceholder: "Search records",
    },
  });
  const upcomingCancelled = $("#example-cancelled").DataTable({
    responsive: true,
    searching: false,
    paging: false,
    info: false,
  });
  
  // // Formatting function for row details - modify as you need
  // function format(d) {
  //     // `d` is the original data object for the row
  //     return (`<div class="container-fluid">
  //         <div class="row">
  //             <div class="col-lg-6">
  //                 <div class="d-flex align-items-center mb-2">
  //                     <h2 class="table-caption">URL:</h2>
  //                     <h2 class="table-value"><a href="https://crm-admin123.netlify.app/">https://crm-admin123.netlify.app/</a></h2>
  //                 </div>
  //                 <div class="d-flex align-items-center mb-2">
  //                     <h2 class="table-caption">State/Country:</h2>
  //                     <h2 class="table-value">Pakistan</h2>
  //                 </div>
  //                 <div class="d-flex align-items-center mb-2">
  //                     <h2 class="table-caption">Address:  </h2>
  //                     <h2 class="table-value">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ex, voluptatibus?</h2>
  //                 </div>
  //                 <div class="d-flex align-items-center mb-2">
  //                     <h2 class="table-caption">Phone Number:   </h2>
  //                     <h2 class="table-value">0300 887 6652</h2>
  //                 </div>
  //                 <div class="d-flex align-items-center mb-2">
  //                     <h2 class="table-caption">Date: </h2>
  //                     <h2 class="table-value">12/8/2023</h2>
  //                 </div>
  //                 <div class="d-flex align-items-center mb-2">
  //                     <h2 class="table-caption">Follow-up Date:</h2>
  //                     <h2 class="table-value">12/8/2023</h2>
  //                 </div>
  //             </div>
  //         </div>
  //       </div>`);
  // }
  
  // let table = new DataTable('#example', {
  //     responsive: true,
  //     scrollX: true,
  //     language: {
  //         searchPlaceholder: "Search records"
  
  //     },
  //     columnDefs: [
  //       {
  //         className: 'dt-control',
  //         orderable: false,
  //         data: null,
  //         defaultContent: '',
  //         targets: 0
  //       }
  //     ]
  // });
  
  // // Add event listener for opening and closing details
  // table.on('click', 'td.dt-control', function (e) {
  //     let tr = e.target.closest('tr');
  //     let row = table.row(tr);
  
  //     if (row.child.isShown()) {
  //         // This row is already open - close it
  //         row.child.hide();
  //     }
  //     else {
  //         // Open this row
  //         row.child(format(row.data())).show();
  //     }
  // });
  