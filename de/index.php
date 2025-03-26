<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schadensarten - Schadenportal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen p-6">

    <div class="bg-white shadow-lg rounded-lg p-6 text-center max-w-2xl w-full">
        <h1 class="text-2xl font-bold mb-4">Schadensarten</h1>
        <p class="text-gray-600 mb-6">W&auml;hlen Sie die Art des Schadens:</p>

        <div class="grid gap-4">
            <!-- Verzugsschaden -->
            <a href="verzugschaden.html" class="block bg-red-100 p-4 rounded-lg shadow-md hover:bg-red-200 transition">
                <h2 class="text-lg font-semibold text-red-600">Verzugsschaden</h2>
                <p class="text-gray-700 text-sm">Schaden durch versp&auml;tete Lieferung oder Nichteinhaltung der Lieferfristen.</p>
            </a>

            <!-- G�terschaden -->
            <a href="gueterschaden.html" class="block bg-blue-100 p-4 rounded-lg shadow-md hover:bg-blue-200 transition">
                <h2 class="text-lg font-semibold text-blue-600">G&uuml;terschaden</h2>
                <p class="text-gray-700 text-sm">Besch&auml;digung oder Verlust der transportierten Ware.</p>
            </a>

            <!-- Unfallmeldung -->
            <a href="unfallmeldung.html" class="block bg-blue-100 p-4 rounded-lg shadow-md hover:bg-blue-200 transition">
                <h2 class="text-lg font-semibold text-blue-600">Unfallmeldung</h2>
                <p class="text-gray-700 text-sm">Meldung eines Unfalls mit dem Fahrzeug oder der Ladung.</p>
            </a>

            <!-- Lagerschaden -->
            <a href="lagerschaden.html" class="block bg-blue-100 p-4 rounded-lg shadow-md hover:bg-blue-200 transition">
                <h2 class="text-lg font-semibold text-blue-600">Lagerschaden</h2>
                <p class="text-gray-700 text-sm">Besch&auml;digung der Ware w&auml;hrend der Lagerung oder beim Umschlag.</p>
            </a>
        </div>
<br>
<button onclick="history.back()" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg">
    Zur&uuml;ck
</button>
        <!-- Zur�ck zur Hauptseite 
        <a href="index.php" class="mt-6 inline-block bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition">
            Zur�ck zur Hauptseite -->
        </a>
    </div>

</body>
</html>
