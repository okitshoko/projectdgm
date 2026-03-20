<!DOCTYPE html>
<html>
<head>
    <title>Alerte DGM</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2 style="color: #0d6efd;">Direction Générale de Migration</h2>
    <p>Bonjour <strong>{{ $details['nom'] }}</strong>,</p>
    
    <p>Ceci est un message automatique pour vous informer que votre autorisation de séjour liée au passeport n°<strong>{{ $details['passeport'] }}</strong> arrive à expiration.</p>
    
    <p><strong>Date d'expiration :</strong> {{ \Carbon\Carbon::parse($details['expiration'])->format('d/m/Y') }}</p>
    
    <p>Veuillez vous présenter aux services de la DGM le plus tôt possible pour régulariser votre situation et éviter tout désagrément.</p>
    
    <hr>
    <p style="font-size: 0.8em; color: gray;">Ceci est un mail automatique, merci de ne pas y répondre.</p>
</body>
</html>