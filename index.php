<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timer</title>

    <!-- CSS Files -->
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

    <div class="main">
        <div class="timer_form_div">

            <!-- <form id="timer_form" class="timer_form" action="" method="POST"> -->
            <div class="">
                <h1 class="">Add New Record</h3>
            </div>
            <div class="">
                <table class="name_table" id="name_table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="text" name="name" id="name" class="name" />
                            </td>
                            <!-- <td>
                                <input type="text" name="time" id="time" class="time" value="00:00:00" />
                            </td> 
                        https://jsfiddle.net/dalinhuang/op8ae79j/
                        -->
                            <td>
                                <input type="hidden" name="row_id" id="hidden_row_id" />
                                <button type="button" name="save" id="save" class="btn btn-info">Add</button>
                            </td>
                        </tr>
                    </tbody>
                    <div id="action_alert" title="Action">

                    </div>
                </table>
            </div>

            <br>
            <br>

            <div class="">
                <h1 class="">Timer</h3>
            </div>
            <div class="" id="mydata">

                <form id="timer_form">
                    <table class="timer_table" id="timer_table">
                        <tr>
                            <th>Name</th>
                            <th>Timer</th>
                            <th colspan="2">Actions</th>
                        </tr>
                    </table>
                    <div>
                        <br>
                        <input type="submit" name="insert" id="insert" class="btn btn-primary" value="Insert" />
                    </div>
                </form>

                <br>
                <br>

                <div class="">
                    <h1 class="">History <button type="button" class="btn btn-info btn-sm" id="loadBtn"><i
                                class="fa fa-refresh"></i> Load More.. </button></h3>
                </div>
                <div class="">
                    <table class="history_table" id="history_table">
                        <thead>
                            <tr>
                                <th>Sl.</th>
                                <th>Name</th>
                                <th>Timer</th>
                            </tr>
                        </thead>
                        <tbody id="history_table_body">
                        <?php

                        include ('db.php');

                         $sql = "SELECT * FROM timer limit 2";
                         $result = mysqli_query($conn, $sql);

                         if (mysqli_num_rows($result) > 0) {
                             $sn=1;
                             $times = mysqli_fetch_all($result, MYSQLI_ASSOC);
                             foreach ($times as $time) : ?>
                            <tr id="result">
                                <td><?php echo $sn; ?> </td>
                                <td><?php echo $time['name']; ?> </td>
                                <td><?php echo $time['time']; ?> </td>
                            </tr>
                            <?php $sn++;
                             endforeach;
                         } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function () {

                var count = 0;

                $('#save').click(function () {
                    var error_name = '';
                    // var error_time = '';
                    var name = '';
                    // var time = '';
                    if ($('#name').val() == '') {
                        error_name = 'First Name is required';
                        $('#error_name').text(error_name);
                        $('#name').css('border-color', '#cc0000');
                        name = '';
                    } else {
                        error_name = '';
                        $('#error_name').text(error_name);
                        $('#name').css('border-color', '');
                        name = $('#name').val();
                    }
                    if (error_name != '') {
                        return false;
                    } else {
                        if ($('#save').text() == 'Add') {
                            count = count + 1;
                            output = '<tr id="row_' + count + '">';
                            output += '<td>' + name +
                                ' <input type="hidden" name="hidden_name[]" id="name' + count +
                                '" class="name" value="' + name + '" /></td>';
                            output += '<td> <span id="output' + count + '">00:00:00</span> <input type="hidden" name="hidden_time[]" id="time' + count +
                                '" value=""/></td>';
                            output +=
                                '<td><button type="button" name="remove_details" class="btn remove_details" id="' +
                                count + '"><i class="fa fa-times"></i></button></td>';
                            output +=
                                '<td><a class="btn" id ="startPause' + count + '" onClick="startPause(' + count + ')"><i class="fa fa-play"></i></a><a class="btn" id="reset" onClick="reset(' + count + ')"><i class="fa fa-refresh"></i></a></td>';
                            output += '</tr>';
                            $('#timer_table').append(output);
                        } else {
                            var row_id = $('#hidden_row_id').val();
                            output = '<td>' + name +
                                ' <input type="hidden" name="hidden_name[]" id="name' + row_id +
                                '" class="name" value="' + name + '" /></td>';
                            output += '<td><span id="output' + row_id + '">00:00:00</span> <input type="hidden" name="hidden_time[]" id="time' + row_id +
                                '" value=""/></td>';
                            output +=
                                '<td><button type="button" name="remove_details" class="btn remove_details" id="' +
                                row_id + '"><i class="fa fa-times"></i></button></td>';
                            output +=
                                '<td><a class="btn" id ="startPause' + row_id + '" onClick="startPause(' + row_id + ')"><i class="fa fa-play"></i></a><a class="btn" id="reset" onClick="reset(' + row_id + ')"><i class="fa fa-refresh"></i></a></td>';
                            $('#row_' + row_id + '').html(output);
                        }
                    }
                });

            

                $(document).on('click', '.remove_details', function () {
                    var row_id = $(this).attr("id");
                    if (confirm("Are you sure you want to remove this row data?")) {
                        $('#row_' + row_id + '').remove();
                    } else {
                        return false;
                    }
                });

                $('#timer_form').on('submit', function (event) {
                    event.preventDefault();
                    var count_data = 0;
                    $('.name').each(function () {
                        count_data = count_data + 1;
                    });
                    if (count_data > 0) {
                        var form_data = $(this).serialize();
                        $.ajax({
                            url: "save.php",
                            method: "POST",
                            data: form_data,
                            success: function (data) {
                                $('#timer_data').find("tr:gt(0)").remove();
                                alert('Data Inserted Successfully');
                            }
                        })
                    }
                });

                $(document).on('click', '#loadBtn', function (e) {
                    $.ajax({
                        type: "GET",
                        url: "load-data.php",
                        dataType: "html",
                        success: function (data) {
                            $("#history_table_body").html(data);

                        }
                    });
                });

            });
        </script>
        <script>
            var time = 0;
            var running = 0;
            
            function startPause(i) {

                //var info = this.i;
                if (running == 0) {
                    running = 1;
                    increment(i);
                    document.getElementById("startPause"+i).innerHTML = "<i class='fa fa-pause'></i>";
                } else {
                    running = 0;
                    document.getElementById("startPause"+i).innerHTML = "<i class='fa fa-play'></i>";
                }
            };
            
            function reset(i) {

                running = 0;
                time = 0;
                document.getElementById("startPause"+i).innerHTML = "<i class='fa fa-play'></i>";
                document.getElementById('output'+ i).innerHTML = "00:00:00";
                document.getElementById('time'+ i).value = "00:00:00";
            };
            
            function increment(i) {
                if (running == 1) {
                    setTimeout(function() {
                        time++;
                        var mins = Math.floor(time/10/60);
                        var secs = Math.floor(time/10 % 60);
                        var tenths = time % 10;
                        if (mins < 10) {
                        mins = "0" + mins;
                        }
                        if (secs < 10) {
                        secs = "0" + secs;
                        }
                        document.getElementById('output'+i).innerHTML = mins + ":" + secs + ":" + "0" + tenths;
                        document.getElementById('time'+i).value = mins + ":" + secs + ":" + "0" + tenths;
                        increment(i);
                    },100);
                }
            }
        </script>

</body>

</html>