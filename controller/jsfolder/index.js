window.onload = function() {
    const shadowRoot = document.querySelector('spline-viewer').shadowRoot;
    if (shadowRoot) {
        const logo = shadowRoot.querySelector('#logo');
        if (logo) logo.remove();
    }
}
document.getElementById('buyButton').addEventListener('click', function () {
     const selectedSeats = document.querySelectorAll('.seat.selected').length;
     const eventName = document.getElementById('movie').selectedOptions[0].text;
     const totalPrice = selectedSeats * document.getElementById('movie').value;

     if (selectedSeats > 0) {
       // Pass data to barcode page
       const query = new URLSearchParams({
         seats: selectedSeats,
         event: eventName,
         price: totalPrice,
       });
       window.location.href = `barcode.html?${query}`;
     } else {
       alert('Please select at least one seat!');
     }
   });