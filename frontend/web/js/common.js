$(document).on("beforeSubmit", "#form-order", function (e) {
//stop submitting the form to see the disabled button effect
    e.preventDefault();

    //disable the submit button
    $("#submit-button").attr("disabled", true);
    var data = $('#form-order').serialize();
    $.ajax({
        url: $('#form-order').attr('action'),
        type: 'POST',
        data: data,
        success: function (data) {
            $("#submit-button").attr("disabled", false);
            if(data.success == true){
                $('#form-order')[0].reset();
                toastr.success('Order Added Successfully');
                loadOrders();
            }
            else {
                if(data.error === "Error"){
                    toastr.error('Something went wrong.');
                } else {
                    toastr.error(data.error);
                }
            }
        }
     });
     $("#submit-button").attr("disabled", false);
     return false;
});

function previewmap(){
    $("#map").html('<div class="loader"></div>');

    var data = $('#form-order').serialize();

    $.ajax({
        url: previewMapUrl,
        type: 'POST',
        data: data,
        success: function (data) {
            if(data.success === true){
                //add map
                loadSingleMap(data)
            }
            else {
                if(data.error === "Error"){
                    toastr.error('Something went wrong.');
                } else {
                    toastr.error(data.error);
                }
                loadOrders();
            }
        }
    });
}
function removeOrder(orderId){
    $("#exampleModal").hide(); $('.modal-backdrop').remove();
    $('body').removeClass('modal-open')
    $.ajax({
        url: removeOrderUrl,
        type: 'POST',
        data: {'orderId': orderId},
        success: function () {
            toastr.success('Order Removed Successfully');
            loadOrders();
        }
    });
}
function resetOrder(){
    loadOrders();
}
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
function loadOrders(order_by="", order=""){
    $("#order-listing").html('<div class="loader"></div>');
    setTimeout(function () {

        $.ajax({
            url: loadOrderUrl,
            type: 'GET',
            data: {order_by:order_by, order:order},
            dataType: "json",
            success: function (data) {
                rendorOrder(data.orders, data.sort)
                $("#map").html('<div class="loader"></div>');
                loadMap(data.orders);
            }
        });
    }, 1101);

}

function rendorOrder(orders, sort){
    var output =  `
    <table class="table listing">
        <thead>
            <tr>
                <th class="text-left"><a class="sort" onclick="loadOrders('first_name', '${sort.first_name === 4 ? 3 : 4}')">First Name</a><i class="fas ${sort.first_name === 3 ? 'fa-sort-down': sort.first_name === 4 ? 'fa-sort-up':''}"></i></th>
                <th class="text-left"><a class="sort" onclick="loadOrders('last_name', '${sort.last_name === 4 ? 3 : 4}')">Last Name</a><i class="fas ${sort.last_name === 3 ? 'fa-sort-down': sort.last_name === 4 ? 'fa-sort-up':''}"></i></th>
                <th class="text-left"><a class="sort" onclick="loadOrders('schedule_date', '${sort.schedule_date === 4 ? 3 : 4}')">Date</a><i class="fas ${sort.schedule_date === 3 ? 'fa-sort-down': sort.schedule_date === 4 ? 'fa-sort-up':''}"></i></th>
                <th class="text-left"></th>
            </tr>
        </thead>
    <tbody>`;
    if(orders.length > 0) {
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
                output += `<span class="listing-close">`;
                if(orders[i].status === 1 || orders[i].status === 2){ //Pending
                    output += `<a data-toggle="modal" data-target="#exampleModal">
                        <i class="fas fa-times-circle ${closedisabled}"></i>
                    </a>
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Remove an Order</h5>
                            </div>
                            <div class="modal-body">
                                Are you Sure you want to remove Order?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="removeOrder(${orders[i].id})">Remove Order</button>
                            </div>
                            </div>
                        </div>
                    </div>`;
                }
                else {
                    output += `<i class="fas fa-times-circle ${closedisabled}"></i>`;
                }
                output += `</span>

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
    }
    else {
        output += `<tr><td colspan="4">No Orders Found.</td></tr>`;
    }
    output += `</tbody>
        </table>`;
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
        var markerIcon, statusText;

        if(orders[i].status === 1){ //Pending
            markerIcon = new  LeafIcon({iconUrl: webAssetsUrl + 'logistics/057-stopwatch.png'});
            statusText = "Pending";
        }
        else if(orders[i].status == 2){ //Assigned
            markerIcon = new  LeafIcon({iconUrl: webAssetsUrl + 'logistics/005-calendar.png'});
            statusText = "Assigned";
        }
        else if(orders[i].status == 3){ //On Route
            markerIcon = new  LeafIcon({iconUrl: webAssetsUrl + 'logistics/028-express-delivery.png'});
            statusText = "On Route";
        }
        else if(orders[i].status == 4){ //Done
            markerIcon = new  LeafIcon({iconUrl: webAssetsUrl + 'logistics/015-delivered.png'});
            statusText = "Done";
        }
        else if(orders[i].status == 5){ //Cancelled
            markerIcon = new  LeafIcon({iconUrl: webAssetsUrl + 'logistics/016-delivery-failed.png'});
            statusText = "Cancelled";
        }
        var marker = L.marker([orders[i].lat, orders[i].lon], {icon: markerIcon})
            .addTo(map).bindPopup(`Order Type: ${statusText}`);
        marker.orderId = orders[i].id;
        marker.on('click', onMarkerClick);

        function onMarkerClick(e) {
            $(".row-class").children('td, th').css('background-color','#fff');;
            $(`#row-class-${e.target.orderId}`).children('td, th').css('background-color','#ccc');
            $(`#row-class-${e.target.orderId}`).get(0).scrollIntoView({behavior: "smooth", block: "start"});
        }

        // $(`#row-class-${orders[i].id}`).click(function(){
        //     marker.click()
        // });
    }
}

function loadSingleMap(data){
    var container = L.DomUtil.get('map');
    if(container != null){
        container._leaflet_id = null;
    }
    var map = L.map('map').setView([data.geocode.lat, data.geocode.lng], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

    var LeafIcon = L.Icon.extend({
        options: {
            iconSize:     [50, 50],
            iconAnchor:   [22, 94],
            popupAnchor:  [-3, -76]
        }
    });
    var markerIcon, statusText;

    markerIcon = new  LeafIcon({iconUrl: webAssetsUrl + 'logistics/057-stopwatch.png'});
    statusText = "Pending";

    L.marker([data.geocode.lat, data.geocode.lng], {icon: markerIcon})
        .addTo(map).bindPopup(`Order Type: ${statusText}`);
}
