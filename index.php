<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schadensmanagement-Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-lg p-8 text-center max-w-lg w-full">
        <!-- Logo -->
        <div class="mb-6">
            <img src="logo.png" alt="Firmenlogo" class="w-32 mx-auto" onerror="this.src='https://via.placeholder.com/150'">
        </div>

        <h1 class="text-2xl font-bold mb-4">Schadensmanagement-Portal</h1>
        <p class="text-gray-600 mb-6">Bitte wählen Sie Ihre Sprache:</p>

        <!-- Sprachauswahl -->
        <div class="space-y-4">
            <button onclick="changeLanguage('de')" class="block w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition">
                Deutsch 🇩🇪
            </button>
            <button onclick="changeLanguage('en')" class="block w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition">
                English 🇬🇧
            </button>
            <button onclick="changeLanguage('hu')" class="block w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition">
                Magyar 🇭🇺
            </button>
            <button onclick="changeLanguage('hr')" class="block w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition">
                Hrvatski 🇭🇷
            </button>
        </div>
    </div>

    <script>
        function changeLanguage(lang) {
            window.location.href = lang + "/index.php"; // Weiterleitung in Sprachordner
        }
    </script>

</body>
</html>


