<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Receipt Print</title>
</head>

<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mui/3.7.1/js/mui.min.js"
        integrity="sha512-5LSZkoyayM01bXhnlp2T6+RLFc+dE4SIZofQMxy/ydOs3D35mgQYf6THIQrwIMmgoyjI+bqjuuj4fQcGLyJFYg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/imin-printer-2.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/dom-to-image.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/vConsole/3.9.1/vconsole.min.js"></script>

    <div style="width: 150mm;font-weight: 600;font-family: monospace;" id="booking_tickets">
        <!-- Office Copy -->
        <div style="width: 150mm;font-weight: 600;font-family: monospace;" class="booking_ticket">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="<?php echo base_url(); ?>/assets/css/Barlow.css" rel="stylesheet">
            <style>
                body {
                    font-family: 'Barlow', sans-serif;
                    background: #fff;
                    box-sizing: border-box;
                }

                table {
                    border-collapse: collapse;
                }

                table td {
                    padding: 5px;
                }

                hr {
                    border: none;
                    border-top: 1px dashed #000;
                    color: #fff;
                    background-color: #fff;
                    height: 1px;
                }

                p {
                    font-size: 20px;
                    text-align: center;
                    font-weight: 600;
                    font-family: monospace;
                    margin: 0px
                }

                h3 {
                    font-size: 32px;
                    text-align: center;
                    font-weight: 600;
                    font-family: monospace;
                    text-transform: uppercase;
                }

                tr td,
                tr th {
                    font-size: 20px;
                }

                .booking_ticket {
                    color: #000;
                    background: #fff;
                    padding: 5px;
                    display: none;
                }

                #ticket_loader {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    width: 100%;
                    height: 100%;
                }

                img {
                    max-width: 100%;
                }
            </style>
            <p style="border-bottom: 3px dotted #9E9E9E;max-width: 150mm;"></p>
            <h3 style="max-width: 150mm;margin: 5px 0;">Office Copy</h3>
            <p style="border-bottom: 3px dotted #9E9E9E;max-width: 150mm;"></p>
            <br>

            <p><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>"
                    style="width:120px;" align="center"></p>
            <h2 style="text-align:center; margin:0"><?php echo $temp_details['name']; ?></h2>
            <p><?php echo $temp_details['address1']; ?>, <?php echo $temp_details['address2']; ?></br>
                <?php echo $temp_details['city'] . '-' . $temp_details['postcode']; ?>.
                Tel: <?= $temp_details['telephone']; ?></p>
            <hr>
            <p style="text-align: center; font-size:28px;">Member Registration Receipt</p>
            <hr>
            <p><b>Date : </b>
                <?php $date = new DateTime($qry1['created']);
                echo $date->format('d-m-Y'); ?>
            </p>
            <p><b>Member No : </b>
                <?php echo $qry1['member_no']; ?>
            </p>
            <p><b>Name : </b>
                <?php echo $qry1['name']; ?>
            </p>
            <p><b>Member Type : </b>
                <?php echo $qry1['tname']; ?>
            </p>
            <p><b>IC No : </b>
                <?php echo $qry1['ic_no']; ?>
            </p>
            <p><b>Mobile : </b>
                <?php echo $qry1['mobile']; ?>
            </p>
            <p><b>Start Date : </b>
                <?php echo date('d-m-Y', strtotime($qry1['start_date'])); ?>
            </p>
            <?php if (!empty($qry1['end_date'])): ?>
                <p><b>End Date : </b>
                    <?php echo date('d-m-Y', strtotime($qry1['end_date'])); ?>
                </p>
            <?php endif; ?>
            <p><b>Amount(SGD) : </b>
            <?php echo number_format((float) $qry1['payment'], 2, '.', ','); ?>
            </p>
            <br>
            <hr>
        </div>

        <!-- Customer Copy -->
        <div style="width: 150mm;font-weight: 600;font-family: monospace;" class="booking_ticket">
            <p style="border-bottom: 3px dotted #9E9E9E;max-width: 150mm;"></p>
            <h3 style="max-width: 150mm;margin: 5px 0; font-size:28px;">Customer Copy</h3>
            <p style="border-bottom: 3px dotted #9E9E9E;max-width: 150mm;"></p>
            <br>

            <p><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>"
                    style="width:120px;" align="center"></p>
            <h2 style="text-align:center; margin:0"><?php echo $temp_details['name']; ?></h2>
            <p><?php echo $temp_details['address1']; ?>, <?php echo $temp_details['address2']; ?></br>
                <?php echo $temp_details['city'] . '-' . $temp_details['postcode']; ?>.
                Tel: <?= $temp_details['telephone']; ?></p>
            <hr>
            <p style="text-align: center;">Member Registration Receipt</p>
            <hr>
            <p><b>Date : </b>
                <?php $date = new DateTime($qry1['created']);
                echo $date->format('d-m-Y'); ?>
            </p>
            <p><b>Member No : </b>
                <?php echo $qry1['member_no']; ?>
            </p>
            <p><b>Name : </b>
                <?php echo $qry1['name']; ?>
            </p>
            <p><b>Member Type : </b>
                <?php echo $qry1['tname']; ?>
            </p>
            <p><b>IC No : </b>
                <?php echo $qry1['ic_no']; ?>
            </p>
            <p><b>Mobile : </b>
                <?php echo $qry1['mobile']; ?>
            </p>
            <p><b>Start Date : </b>
                <?php echo date('d-m-Y', strtotime($qry1['start_date'])); ?>
            </p>
            <?php if (!empty($qry1['end_date'])): ?>
                <p><b>End Date : </b>
                    <?php echo date('d-m-Y', strtotime($qry1['end_date'])); ?>
                </p>
            <?php endif; ?>
            <p><b>Amount(SGD) : </b>
            <?php echo number_format((float) $qry1['payment'], 2, '.', ','); ?>
            </p>
            <br>
            <hr>
        </div>
    </div>

    <div class="ticket_loader">
        <img src="<?php echo base_url(); ?>/assets/images/loader.gif" />
    </div>

    <script>
        var vConsole = new VConsole();
        var IminPrintInstance = new IminPrinter();
        console.log('IminPrintInstance');
        console.log(IminPrintInstance);
        let isConnect = false;

        IminPrintInstance.connect().then(async (connect) => {
            if (connect) {
                isConnect = true;
                $('.ticket_loader').hide();
                $('.booking_ticket').show();
                initiate_load();
            } else {
                alert('Printer connection error');
                setTimeout(function () {
                    window.location.href = "<?php echo base_url(); ?>/member";
                }, 2000);
            }
        });

        function initiate_load() {
            if (isConnect) {
                var tot_count = $('#booking_tickets .booking_ticket').length;
                var ticket = [];
                console.log(IminPrintInstance.getPrinterStatus());
                IminPrintInstance.initPrinter();

                var i = 0;
                $('#booking_tickets .booking_ticket').each(function () {
                    var node = this;
                    domtoimage.toJpeg(node).then(function (dataUrl) {
                        console.log('i=' + i);
                        ticket[i] = dataUrl;
                        if (i >= (tot_count - 1)) {
                            print_queue(IminPrintInstance, ticket, 0);
                        }
                        i++;
                    });
                });
            }
        }

        async function print_queue(IminPrintInstance, ticket, i) {
            if (i < ticket.length) {
                console.log(IminPrintInstance.getPrinterStatus());
                console.log('Printing ticket ' + (i + 1));
                await IminPrintInstance.printSingleBitmap(ticket[i]);
                await IminPrintInstance.printAndFeedPaper(100);
                await IminPrintInstance.partialCut();
                print_queue(IminPrintInstance, ticket, i + 1);
            } else {
                setTimeout(function () {
                    window.location.href = "<?php echo base_url(); ?>/member";
                }, 500);
            }
        }
    </script>
</body>

</html>