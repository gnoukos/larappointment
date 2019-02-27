<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<style>
    body {
        padding: 0;
        margin: 0;
    }
    html {
        -webkit-text-size-adjust: none;
        -ms-text-size-adjust: none;
    }
    @media only screen and (max-device-width: 680px), only screen and (max-width: 680px) {
        *[class="table_width_100"] {
            width: 96% !important;
        }
        *[class="border-right_mob"] {
            border-right: 1px solid #dddddd;
        }
        *[class="mob_100"] {
            width: 100% !important;
        }
        *[class="mob_center"] {
            text-align: center !important;
        }
        *[class="mob_center_bl"] {
            float: none !important;
            display: block !important;
            margin: 0px auto;
        }
        .iage_footer a {
            text-decoration: none;
            color: #929ca8;
        }
        img.mob_display_none {
            width: 0px !important;
            height: 0px !important;
            display: none !important;
        }
        img.mob_width_50 {
            width: 40% !important;
            height: auto !important;
        }
    }
    .table_width_100 {
        width: 680px;
    }
</style>
<!------ Include the above in your HEAD tag ---------->
<!--
   Responsive Email Template by @keenthemes
   A component of Metronic Theme - #1 Selling Bootstrap 3 Admin Theme in Themeforest: http://j.mp/metronictheme
   Licensed under MIT
   -->
<div id="mailsub" class="notification" align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width: 320px;">
        <tr>
            <td align="center" bgcolor="#eff3f8">
                <!--[if gte mso 10]>
                <table width="680" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                <![endif]-->
                <table border="0" cellspacing="0" cellpadding="0" class="table_width_100" width="100%"
                       style="max-width: 680px; min-width: 300px;">
                    <tr>
                        <td>
                            <!-- padding -->
                            <div style="height: 80px; line-height: 80px; font-size: 10px;"> </div>
                        </td>
                    </tr>
                    <!--header -->
                    <tr>
                        <td align="center" bgcolor="#ffffff">
                            <!-- padding -->
                            <div style="height: 30px; line-height: 30px; font-size: 10px;"> </div>
                            <table width="90%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="left">
                                        <!--
                                           Item -->
                                        <div class="mob_center_bl"
                                             style="float: left; display: inline-block; width: 115px;">
                                            <table class="mob_center" width="115" border="0" cellspacing="0"
                                                   cellpadding="0" align="left" style="border-collapse: collapse;">
                                                <tr>
                                                    <td align="left" valign="middle">
                                                        <!-- padding -->
                                                        <div style="height: 20px; line-height: 20px; font-size: 10px;">

                                                        </div>
                                                        <table width="115" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td align="left" valign="top" class="mob_center">
                                                                    <a href="{{ config('app.url') }}" target="_blank"
                                                                       style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;">
                                                                        <font face="Arial, Helvetica, sans-seri; font-size: 13px;"
                                                                              size="3" color="#596167">
                                                                            <p>{{ config('app.name', 'Larappointment') }}</p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <!-- Item END--><!--[if gte mso 10]>
                                        </td>
                                        <td align="right">
                                        <![endif]--><!--
                                       Item -->
                                        <div class="mob_center_bl"
                                             style="float: right; display: inline-block; width: 88px;">
                                            <table width="88" border="0" cellspacing="0" cellpadding="0" align="right"
                                                   style="border-collapse: collapse;">
                                                <tr>
                                                    <td align="right" valign="middle">
                                                        <!-- padding -->
                                                        <div style="height: 20px; line-height: 20px; font-size: 10px;">

                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div><!-- Item END--></td>
                                </tr>
                            </table>
                            <!-- padding -->
                            <div style="height: 50px; line-height: 50px; font-size: 10px;"> </div>
                        </td>
                    </tr>
                    <!--header END-->
                    <!--content 1 -->
                    <tr>
                        <td align="center" bgcolor="#fbfcfd">
                            <table width="90%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center">
                                        <!-- padding -->
                                        <div style="height: 60px; line-height: 60px; font-size: 10px;"> </div>
                                        <div style="line-height: 44px;">
                                            <font face="Arial, Helvetica, sans-serif" size="5" color="#57697e"
                                                  style="font-size: 34px;">
                        <span style="font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;">
                        Ticket
                        </span></font>
                                        </div>
                                        <!-- padding -->
                                        <div style="height: 40px; line-height: 40px; font-size: 10px;"> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div style="line-height: 24px;">
                                            <font face="Arial, Helvetica, sans-serif" size="4" color="#57697e"
                                                  style="font-size: 15px;">
                        <span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">
                        Your Ticket for:
                            <span class="text-success">
                                @for ($i=0; $i<count($parents); $i++ )
                                    @if ($i!=count($parents)-1)
                                        {{$parents[$i]}} ->
                                    @else
                                        {{$parents[$i]}}
                                    @endif
                                @endfor
                            </span>, at: <span class="text-success">{{ \Carbon\Carbon::parse($timeslot->slot)->format('l d/m/Y') }}</span> - <span class="text-success">{{ \Carbon\Carbon::parse($startingHour)->format('H:i') }} is {{ $timeslot->ticket_num }}</span>
                        </span></font>
                                        </div>
                                        <!-- padding -->
                                        <div style="height: 40px; line-height: 40px; font-size: 10px;"> </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--content 1 END-->

                    <!--footer -->
                    <tr>
                        <td class="iage_footer" align="center" bgcolor="#ffffff">
                            <!-- padding -->
                            <div style="height: 80px; line-height: 80px; font-size: 10px;"> </div>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center">
                                        <font face="Arial, Helvetica, sans-serif" size="3" color="#96a5b5"
                                              style="font-size: 13px;">
                                       <span style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">
                                       Larappointment
                                       </span></font>
                                    </td>
                                </tr>
                            </table>
                            <!-- padding -->
                            <div style="height: 30px; line-height: 30px; font-size: 10px;"> </div>
                        </td>
                    </tr>
                    <!--footer END-->
                    <tr>
                        <td>
                            <!-- padding -->
                            <div style="height: 80px; line-height: 80px; font-size: 10px;"> </div>
                        </td>
                    </tr>
                </table>
                <!--[if gte mso 10]>
                </td>
                </tr>
                </table>
                <![endif]-->
            </td>
        </tr>
    </table>
</div>