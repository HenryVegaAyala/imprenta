<?php
use yii\helpers\Url;

$this->title = 'Sistema de Gestión Documentaria';
?>

<div class="right_col" role="main">

    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Actividades Recientes</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="dashboard-widget-content">
                        <ul class="list-unstyled timeline widget">
                            <?php foreach ($notificaciones AS $notificacion) { ?>
                                <li>
                                    <div class="block">
                                        <div class="block_content">
                                            <h2 class="title">
                                                <a><?php echo $notificacion['titulo'] ?></a>
                                            </h2>
                                            <div class="byline">
                                                <span><?php echo $notificacion['creado'] ?></span> por
                                                <a><?php echo $notificacion['usuario'] ?></a>
                                            </div>
                                            <p class="excerpt"><?php echo $notificacion['descripcion'] ?>
                                                <a href="<?= Url::to(['/proforma/index']); ?>"> Leer más</a>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Bandeja de Correos</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-sm-3 mail_list_column">
                                    <a href="#">
                                        <div class="mail_list">
                                            <div class="left">
                                                <i class="fa fa-circle"></i> <i class="fa fa-edit"></i>
                                            </div>
                                            <div class="right">
                                                <h3>Dennis Mugo
                                                    <small>3.00 PM</small>
                                                </h3>
                                                <p>Requiero cotización de los siguientes productos.</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!-- /MAIL LIST -->

                                <!-- CONTENT MAIL -->
                                <div class="col-sm-9 mail_view">
                                    <div class="inbox-body">
                                        <div class="mail_heading row">
                                            <div class="col-md-12">
                                                <h4> Informe de productos de la siguiente lista.</h4>
                                            </div>
                                        </div>
                                        <div class="sender-info">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <strong>Dennis Mugo</strong>
                                                    <span>(dennis.mugo@gmail.com)</span> para
                                                    <strong>Mí</strong>
                                                    <a class="sender-dropdown"><i class="fa fa-chevron-down"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="view-mail">
                                            <p>Cartilla Bingo</p>
                                            <p>Papel foto de 50 x 50</p>
                                            <p>Revista de productos</p>
                                        </div>
                                    </div>

                                </div>
                                <!-- /CONTENT MAIL -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    //
    //$hostname = '{192.168.1.38:143/novalidate-cert}INBOX';
    //$username = 'admin@branusac.pe';
    //$password = '123456';
    //
    //$inbox = imap_open($hostname, $username, $password);

    //$comprobar = imap_mailboxmsginfo($inbox);
    //
    //if ($comprobar) {
    //    echo "Fecha: "       . $comprobar->Date    . "<br />\n" ;
    //    echo "Controlador: " . $comprobar->Driver  . "<br />\n" ;
    //    echo "Buzón: "       . $comprobar->Mailbox . "<br />\n" ;
    //    echo "Mensajes: "    . $comprobar->Nmsgs   . "<br />\n" ;
    //    echo "Recientes: "   . $comprobar->Recent  . "<br />\n" ;
    //    echo "No leídos: "   . $comprobar->Unread  . "<br />\n" ;
    //    echo "Eliminados: "  . $comprobar->Deleted . "<br />\n" ;
    //    echo "Tamaño: "      . $comprobar->Size    . "<br />\n" ;
    //} else {
    //    echo "Falló imap_mailboxmsginfo(): " . imap_last_error() . "<br />\n";
    //}
    //
    //
    //imap_close($mbox);

    //    $emails = imap_search($inbox, 'ALL');
    //
    //    /* if emails are returned, cycle through each... */
    //    if ($emails) {
    //        /* begin output var */
    //        $output = '';
    //
    //        /* put the newest emails on top */
    //        rsort($emails);
    //
    //        /* for every email... */
    //        foreach ($emails as $email_number) {
    //            //$email_number=$emails[0];
    ////print_r($emails);
    //            /* get information specific to this email */
    //            $overview = imap_fetch_overview($inbox, $email_number, 0);
    //            $message = imap_fetchbody($inbox, $email_number, 2);
    //
    //            /* output the email header information */
    //            $output .= '<div class="toggler ' . ($overview[0]->seen ? 'read' : 'unread') . '">';
    //            $output .= '<span class="subject">' . $overview[0]->subject . '</span> ';
    //            $output .= '<span class="from">' . $overview[0]->from . '</span>';
    //            $output .= '<span class="date">on ' . $overview[0]->date . '</span>';
    //            $output .= '</div>';
    //
    //            /* output the email body */
    //            $output .= '<div class="body">' . $message . '</div>';
    //        }
    //
    //        echo $output;
    //    }
    //
    //    /* close the connection */
    //    imap_close($inbox);

    ?>


</div>
<!-- /page content -->

