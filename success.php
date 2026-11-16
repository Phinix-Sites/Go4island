<?php
header('Content-Type: text/html; charset=utf-8');

$name  = 'Cliente';
$total = '0.00';
$lang  = 'es';

$session_id = $_GET['session_id'] ?? null;

if ($session_id) {
    $autoload = __DIR__ . '/vendor/autoload.php';
    if (file_exists($autoload)) {
        try {
            require $autoload;
            \Stripe\Stripe::setApiKey("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");
            $session = \Stripe\Checkout\Session::retrieve($session_id, ['expand' => ['customer_details']]);
            $meta    = $session->metadata;
            $name    = $meta['nom']   ?? ($session->customer_details->name ?? 'Cliente');
            $total   = $meta['total'] ?? '0.00';
            $lang    = $meta['lang']  ?? 'es';
        } catch (Exception $e) {
            error_log('success.php stripe error: ' . $e->getMessage());
        }
    }
}

$texts = [
    'es' => [
        'title'   => 'Pago Confirmado',
        'h1'      => 'Pago Confirmado',
        'gracias' => '¡Gracias',
        'msg'     => '¡Su pago ha sido procesado con éxito!',
        'mail'    => 'Recibirá un PDF y los detalles de su reserva por email.',
        'btn'     => 'Volver al sitio',
        'footer'  => 'go4island.com — Alquiler de vehículos en las islas',
    ],
    'en' => [
        'title'   => 'Payment Confirmed',
        'h1'      => 'Payment Confirmed',
        'gracias' => 'Thank you',
        'msg'     => 'Your payment has been processed successfully!',
        'mail'    => 'You will receive a PDF and your booking details by email.',
        'btn'     => 'Back to website',
        'footer'  => 'go4island.com — Vehicle Rental on the Islands',
    ],
    'fr' => [
        'title'   => 'Paiement Confirmé',
        'h1'      => 'Paiement Confirmé',
        'gracias' => 'Merci',
        'msg'     => 'Votre paiement a été effectué avec succès !',
        'mail'    => 'Vous recevrez un PDF et les détails de votre réservation par e-mail.',
        'btn'     => 'Retour au site',
        'footer'  => 'go4island.com — Location de véhicules sur les îles',
    ],
];

$t = $texts[$lang] ?? $texts['es'];
?>
<!doctype html>
<html lang="<?= $lang ?>">
<head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KDXFKW9H');</script>
<!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <title><?= $t['title'] ?> | go4island.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: #fff;
            max-width: 520px;
            width: 100%;
            padding: 48px 36px 40px;
            border-radius: 20px;
            box-shadow: 0 24px 48px rgba(0,0,0,0.12);
            text-align: center;
        }
        .logo {
            margin-bottom: 24px;
        }
        .logo img {
            max-height: 60px;
            max-width: 200px;
        }
        .logo-text {
            font-size: 22px;
            font-weight: 800;
            color: #1d4ed8;
            letter-spacing: -0.5px;
        }
        .check {
            width: 80px;
            height: 80px;
            background: #dcfce7;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            color: #16a34a;
        }
        h1 {
            color: #16a34a;
            font-size: 26px;
            margin-bottom: 12px;
        }
        p {
            color: #374151;
            line-height: 1.7;
            font-size: 15px;
            margin-bottom: 10px;
        }
        .amount {
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 22px;
            font-weight: 800;
            padding: 8px 22px;
            border-radius: 10px;
            margin: 14px 0 18px;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 14px 28px;
            background: #1d4ed8;
            color: #fff;
            font-weight: bold;
            font-size: 15px;
            border-radius: 12px;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn:hover { background: #1e40af; }
        .divider {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 24px 0 18px;
        }
        .footer {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 8px;
        }
        .footer a {
            color: #1d4ed8;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <script>
window.dataLayer = window.dataLayer || [];
window.dataLayer.push({
    'event': 'purchase',
    'value': '<?= floatval($total) ?>',
    'transaction_id': '<?= htmlspecialchars($session_id) ?>'
});
</script>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KDXFKW9H"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="card">

    <div class="logo">
        <?php
        $logoPath = __DIR__ . '/fpdf/logo-go4island.png';
        if (file_exists($logoPath)): ?>
            <img src="/fpdf/logo-go4island.png" alt="go4island.com">
        <?php else: ?>
            <div class="logo-text">go4island.com</div>
        <?php endif; ?>
    </div>

    <div class="check">✔</div>

    <h1><?= $t['h1'] ?></h1>

    <p><?= $t['gracias'] ?>, <strong><?= htmlspecialchars($name) ?></strong>!<br><?= $t['msg'] ?></p>

    <div class="amount">€<?= htmlspecialchars($total) ?></div>

    <p>📧 <?= $t['mail'] ?></p>

    <a class="btn" href="/"><?= $t['btn'] ?></a>

    <hr class="divider">

    <div class="footer">
        <?= $t['footer'] ?><br>
        <a href="mailto:contact@go4island.com">contact@go4island.com</a>
    </div>

</div>
</body>
</html>
