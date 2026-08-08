<x-mail::message>
# Halo {{ $booking->nama }},

Pembayaran Pelunasan untuk perjalanan Anda telah kami terima dan status pesanan Anda kini dinyatakan **LUNAS**.

<x-mail::panel>
### Rincian Invoice Pelunasan (Lunas):
- **Destinasi:** {{ $booking->destination->name }}
- **Tanggal Keberangkatan:** {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
- **Jumlah Peserta:** {{ $booking->jumlah_orang }} Pax
- **Total Biaya:** Rp {{ number_format($booking->total_price, 0, ',', '.') }}
- **Status Pembayaran:** **Lunas (100%)**
</x-mail::panel>

Persiapan keberangkatan Anda telah selesai. Informasi lebih detail mengenai logistik, barang bawaan, dan koordinasi keberangkatan akan didiskusikan di grup koordinasi WhatsApp.

Sampai jumpa di hari keberangkatan!

Terima kasih,<br>
Tim Travelingin.id
</x-mail::message>
