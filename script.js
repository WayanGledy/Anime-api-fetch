document.getElementById("effectForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const mode = document.getElementById("mode").value;
    const text = document.getElementById("text").value;
    const imageOutput = document.getElementById("generatedImage");

    let link;

    switch (mode) {
        case 'glitchtext':
            link = 'https://en.ephoto360.com/create-digital-glitch-text-effects-online-767.html';
            break;
        case 'writetext':
            link = 'https://en.ephoto360.com/write-text-on-wet-glass-online-589.html';
            break;
        case 'advancedglow':
            link = 'https://en.ephoto360.com/advanced-glow-effects-74.html';
            break;
        case 'typographytext':
            link = 'https://en.ephoto360.com/create-typography-text-effect-on-pavement-online-774.html';
            break;
        case 'pixelglitch':
            link = 'https://en.ephoto360.com/create-pixel-glitch-text-effect-online-769.html';
            break;
        case 'neonglitch':
            link = 'https://en.ephoto360.com/create-impressive-neon-glitch-text-effects-online-768.html';
            break;
        // Tambahkan case lainnya sesuai kode
        default:
            alert("Mode tidak dikenali.");
            return;
    }

    // Buat permintaan untuk mendapatkan gambar dengan menggunakan teks input
    fetchImageFromMode(link, text, imageOutput);
});

function fetchImageFromMode(link, text, imageOutput) {
    // Contoh fetching ke API eksternal atau URL terkait
    const generatedImageUrl = `${link}?text=${encodeURIComponent(text)}`;

    // Misal API bisa digunakan untuk mengembalikan gambar
    imageOutput.src = generatedImageUrl;
    imageOutput.style.display = "block";
