function loadPaket() {
    fetch('../api/paket.php')
        .then(res => res.json())
        .then(data => {
            const body = document.getElementById('paket-tableBody');
            body.innerHTML = '';

            data.forEach(p => {
                body.innerHTML += `
                <tr>
                    <td>${p.nama}</td>
                    <td>${p.harga_sumatera}</td>
                    <td>${p.harga_jawa}</td>
                    <td>${p.harga_timur}</td>
                    <td>${p.status == 1 ? 'Aktif' : 'Nonaktif'}</td>
                </tr>`;
            });
        });
}

function addPaket() {
    const data = {
        nama: nama.value,
        sumatera: sumatera.value,
        jawa: jawa.value,
        timur: timur.value,
        status: status.value
    };

    fetch('../api/paket.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    }).then(() => loadPaket());
}

loadPaket();
