const products = [
  {
    id: 1,
    name: "Laptop",
    harga: 15000000,
    deskripsi:
      "Laptop dengan spesifikasi tinggi untuk gaming dan pekerjaan berat.",
    kategori: "Elektronik",
    gambar: "https://placehold.co/300x200",
  },
  {
    id: 2,
    name: "Smartphone",
    harga: 5000000,
    deskripsi: "Smartphone dengan kamera canggih dan performa cepat.",
    kategori: "Elektronik",
    gambar: "https://placehold.co/300x200",
  },
  {
    id: 3,
    name: "Kamera DSLR",
    harga: 12000000,
    deskripsi:
      "Kamera DSLR dengan lensa berkualitas untuk fotografi profesional.",
    kategori: "Elektronik",
    gambar: "https://placehold.co/300x200",
  },
  {
    id: 4,
    name: "Headphone",
    harga: 800000,
    deskripsi: "Headphone dengan suara jernih dan desain ergonomis.",
    kategori: "Aksesoris",
    gambar: "https://placehold.co/300x200",
  },
  {
    id: 5,
    name: "Jam Tangan Pintar",
    harga: 2000000,
    deskripsi:
      "Jam tangan pintar dengan berbagai fitur kesehatan dan notifikasi.",
    kategori: "Aksesoris",
    gambar: "https://placehold.co/300x200",
  },
];

function displayProducts(productsToDisplay) {
  const productContainer = document.getElementById("productContainer");
  productContainer.innerHTML = "";

  if (productsToDisplay.length === 0) {
    productContainer.innerHTML = "<p>Tidak ada produk yang ditemukan.</p>";
    return;
  }
  productsToDisplay.forEach((product) => {
    const productElement = document.createElement("div");
    productElement.innerHTML = `
            <img src="${product.gambar}" alt="${product.name}">
            <h3>${product.name}</h3>
            <p>Harga: Rp ${product.harga.toLocaleString()}</p>
            <p>${product.deskripsi}</p>
            <p>Kategori: ${product.kategori}</p>
        `;
    productContainer.appendChild(productElement);
  });
}
function filterProducts() {
  const selectedCategory = document.getElementById("category-filter").value;
  if (selectedCategory === "all") {
    displayProducts(products);
  } else {
    const filteredProducts = products.filter(
      (product) => product.kategori === selectedCategory
    );
    displayProducts(filteredProducts);
  }
}
document.addEventListener("DOMContentLoaded", () => {
  displayProducts(products);
  document
    .getElementById("category-filter")
    .addEventListener("change", filterProducts);
});
