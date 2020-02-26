function changeStatus(orderId, status){
    $.ajax({
        url: changeStatusUrl,
        type: 'POST',
        data: {'orderId': orderId, 'status':status},
        success: function (data) {
            loadOrders();
        }
     });
}
function loadOrders(){
    $("#order-listing").html('<div class="loader"></div>');
    setTimeout(function () {

        $.ajax({
            url: loadOrderUrl,
            type: 'GET',
            data: {},
            dataType: "json",
            success: function (data) {
                rendorOrder(data.orders)
                $("#map").html('<div class="loader"></div>');
                loadMap(data.orders);
            }
        });
    }, 1101);

}

function rendorOrder(orders){
    var output =  `<div class="table-responsive">
    <table class="table listing">
        <thead>
            <tr>
                <th class="text-left">First Name</th>
                <th class="text-left">Last Name</th>
                <th class="text-left">Date</th>
                <th class="text-left"></th>
            </tr>
        </thead>
    <tbody>`;
    for(var i=0; i< orders.length; i++){
        output += `<tr class="row-class" id="row-class-${orders[i].id}">
                <td class="text-left">${orders[i].first_name}</td>
                <td class="text-left">${orders[i].last_name}</td>
                <td class="text-left">${orders[i].schedule_date}</td>
                <td class="text-left">`;

                    var statusText = "Pending";
                    var statusColor = " btn-default";
                    var closedisabled = " disabled";
                    if(orders[i].status === 1){ //Pending
                        statusText = "Pending";
                        statusColor = " btn-default";
                        closedisabled = "";
                    }
                    else if(orders[i].status == 2){ //Assigned
                        statusText = "Assigned";
                        statusColor = " btn-primary";
                        closedisabled = "";
                    }
                    else if(orders[i].status == 3){ //On Route
                        statusText = "On Route";
                        statusColor = " btn-warning";
                    }
                    else if(orders[i].status == 4){ //Done
                        statusText = "Done";
                        statusColor = " btn-success";
                    }
                    else if(orders[i].status == 5){ //Cancelled
                        statusText = "Cancelled";
                        statusColor = " btn-danger";
                    }
                    output += `<span class="listing-close"><i class="fas fa-times-circle ${closedisabled}"></i></span>
                    <div class="dropdown">
                        <button class="btn ${statusColor} dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            ${statusText}
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">`;
                        if(orders[i].status !== 1) {
                            output += `<li><a onclick="changeStatus(${orders[i].id}, 1)" href="javascript:void(0)">Pending</a></li>`;
                        }
                        if(orders[i].status !== 2) {
                            output += `<li><a onclick="changeStatus(${orders[i].id}, 2)" href="javascript:void(0)">Assigned</a></li>`;
                        }
                        if(orders[i].status !== 3) {
                            output += `<li><a onclick="changeStatus(${orders[i].id}, 3)" href="javascript:void(0)">On Route</a></li>`;
                        }
                        if(orders[i].status !== 4) {
                            output += `<li><a onclick="changeStatus(${orders[i].id}, 4)" href="javascript:void(0)">Done</a></li>`;
                        }
                        if(orders[i].status !== 5) {
                            output += `<li><a onclick="changeStatus(${orders[i].id}, 5)" href="javascript:void(0)">Cancelled</a></li>`;
                        }
                        output += `</ul>
                    </div>
                </td>
            </tr>`
           }
        output += `</tbody>
     </table>
    </div>`;
    $("#order-listing").html(output);
}

function loadMap(orders){

    var container = L.DomUtil.get('map');
    if(container != null){
        container._leaflet_id = null;
    }
    var map = L.map('map').setView([43.64701, -79.39425], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

    var LeafIcon = L.Icon.extend({
        options: {
            iconSize:     [25, 25],
            iconAnchor:   [22, 94],
            popupAnchor:  [-3, -76]
        }
    });
    for(var i=0; i< orders.length; i++){
        if(orders[i].status === 1){ //Pending
            var markerIcon = new  LeafIcon({iconUrl: webAssetsUrl + 'logistics/057-stopwatch.png'});
        }
        else if(orders[i].status == 2){ //Assigned
            var markerIcon = new  LeafIcon({iconUrl: webAssetsUrl + 'logistics/005-calendar.png'});
        }
        else if(orders[i].status == 3){ //On Route
            var markerIcon = new  LeafIcon({iconUrl: webAssetsUrl + 'logistics/028-express-delivery.png'});
        }
        else if(orders[i].status == 4){ //Done
            var markerIcon = new  LeafIcon({iconUrl: webAssetsUrl + 'logistics/015-delivered.png'});
        }
        else if(orders[i].status == 5){ //Cancelled
            var markerIcon = new  LeafIcon({iconUrl: webAssetsUrl + 'logistics/016-delivery-failed.png'});
        }
        var marker = L.marker([orders[i].lat, orders[i].lon], {icon: markerIcon}).addTo(map);
        marker.orderId = orders[i].id;
        marker.on('click', onMarkerClick);

        function onMarkerClick(e) {
            $(".row-class").children('td, th').css('background-color','#fff');;
            $(`#row-class-${e.target.orderId}`).children('td, th').css('background-color','#ccc');
            $(`#row-class-${e.target.orderId}`).get(0).scrollIntoView({behavior: "smooth", block: "start"});
        }

    }
}
