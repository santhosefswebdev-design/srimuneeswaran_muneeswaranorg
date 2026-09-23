<?php global $lang; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Your custom CSS file if any -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/path/to/your/custom.css">
</head>
<style>
    .table-responsive {
        overflow-x: hidden;
    }

    .custom-border {
        border: 2px solid black;
        border-radius: 50%;
        background-color: lightgray;
        padding: 5px;
    }

    .card {
        border: 0;
    }

    input[type="text"] {
        border: none;
        border-bottom: 1px solid black;
        outline: none;
    }

    .or_no {
        border: none !important;

    }

    .dotted-border {
        border: none;
        border-bottom: 1px dotted #000 !important;

    }

    .double-border {
        margin-top: 25px;
        height: 5px;
        border-top: 2px solid black !important;
        border-bottom: 1px solid black !important;
        margin-top: 0px;
    }
    .kumbam-donation{
        border-radius: 20px;
    }
</style>

<body>

    <section class="content">
        <div class="table-responsive">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 " style="margin-left: 40px" ;>
                                    <!-- Image -->
                                    <img src="<?php echo base_url(); ?>/assets/images/rajamari.jpg"
                                        style="width:150px; display:block;">
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-center ">
                                    <!-- Heading -->
                                    <h4>அருள்மிகு இராஜமாரியம்மன் தேவஸ்தானம்</h4>
                                    <h3>ARULMIGU RAJAMARIAMMAN DEVASTHANAM</h3>
                                    <p><b>(Since 1911)</br>No. 1A, Jalan Ungku Puan, 80000 Johor Bahru, Johor,Tel:
                                            07-2233989 Fax: 07-2242989</b></p>

                                </div>

                            </div>
                            </br>
                            <div class="row">
                                <div class="kumbam-donation col-lg-7 col-md-7 col-sm-7 col-xs-12 text-center bg-primary text-light">
                                    <h5>7 வது மஹா கும்பாபிஷேக திருப்பணி நன்கொடை</h5>
                                    <h3>7th MAHA KUMBABISHEGAM DONATION </h3>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-center">

                                    <div style="margin-left:10px" ;>
                                        <label for="orno">OR No:</label>

                                        <input class="or_no" type="text" id="orno" name="orno" value="<?php echo $qry1['ref_no']; ?>">
                                    </div>
                                    <div>
                                        <label for="kumbabishegamDate">Date:</label>
                                        <?php

                                        $formatted_date = date('d-m-Y', strtotime($qry1['date']));
                                        ?>
                                        <input type="text" id="kumbabishegamDate" name="kumbabishegamDate"
                                            value="<?php echo $formatted_date; ?>">
                                    </div>
                                </div>


                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" ;>
                                    <label for="receivedFrom" style="margin-right: 14px;">Received from:</label>
                                    <input type="text" id="receivedFrom" name="receivedFrom"
                                        value="<?php echo $qry1['name']; ?>" style="width: 79%" ;>
                                    <br>
                                    <br>
                                    <label for="sumOfRM" style="margin-right: 10px;">The sum of RM:</label>
                                    <input type="text" id="sumOfRM" name="sumOfRM"
                                        value="<?php echo number_format($qry1['amount'], '2', '.', ','); ?>"
                                        style="width: 79%" ;>
                                    <br>
                                    <br>
                                    <label for="paymentFor" style="margin-right: 26px;">Payment For:</label>
                                    <input type="text" id="paymentFor" name="paymentFor"
                                        style="width: 79%; font-weight: bold; font-size: 24px"
                                        value="<?php echo htmlentities($qry1['pname']); ?>">

                                    <br>
                                    <br>
                                    <label for="remark" style="margin-right: 59px;">Remark:</label>
                                    <input type="text" id="remark" name="remark"
                                        value="<?php echo $qry1['description']; ?>" style="width: 79%" ;>
                                </div>


                            </div>

                            <br>
                            <br>
                            <div class="d-flex" style="width: 90%; text-align: center; " ;>
                                <p><b>RM</b></p>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-bottom: 20px;">
                                    <input type="text" id="cashChequeNo" name="cashChequeNo"
                                        style="width: 100%; border:none !important">
                                        <hr class="double-border">
                                    
                                    <label for="cashChequeNo">Cash/Cheque No.</label>
                                </div>


                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                                    <input class="dotted-border" type="text" id="authorisedCollector"
                                        name="authorisedCollector" style="width: 100%;">
                                    <br>
                                    <br>
                                    <label for="authorisedCollector">Authorised Collector</label>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <input class="dotted-border" type="text" id="honTreasurer" name="honTreasurer"
                                        style="width: 100%;">
                                    <br>
                                    <br>
                                    <label for="honTreasurer">Hon. Treasurer</label>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <p style="font-weight: 800 ; font-size: 19px ;">
                                        <span style="margin-right: 35px;">நன்கொடை வழங்கியமைக்கு நன்றி!</span>
                                        <img src="<?php echo base_url(); ?>/assets/images/hand.png"
                                            style="width: 35px; display: inline-block; vertical-align: middle; margin-bottom: 5px;">
                                        <span style="margin-left: 35px;">Thank You for your generous
                                            contribution!</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        window.print();
    </script>
</body>

</html>