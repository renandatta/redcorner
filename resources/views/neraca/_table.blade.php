<table class="table">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th>Keterangan</th>
        <th class="text-right">Debit</th>
        <th class="text-right">Kredit</th>
        <th class="text-right">Saldo</th>
    </tr>
    </thead>
    <tbody>
        @php($saldo = $simpanan->sum('total_nominal'))
        <tr>
            <td>1</td>
            <td>Simpanan</td>
            <td class="text-right text-nowrap">{{ format_number($simpanan->sum('total_nominal')) }}</td>
            <td></td>
            <td class="text-right text-nowrap">{{ format_number($saldo) }}</td>
        </tr>
        @php($saldo = $saldo - $pinjaman->sum('total_nominal'))
        <tr>
            <td>2</td>
            <td>Pinjaman</td>
            <td></td>
            <td class="text-right text-nowrap">{{ format_number($pinjaman->sum('total_nominal')) }}</td>
            <td class="text-right text-nowrap">{{ format_number($saldo) }}</td>
        </tr>
        @php($saldo = $saldo + $pembayaran->sum('total_nominal'))
        <tr>
            <td>3</td>
            <td>Pembayaran Pinjaman</td>
            <td></td>
            <td class="text-right text-nowrap">{{ format_number($pembayaran->sum('total_nominal')) }}</td>
            <td class="text-right text-nowrap">{{ format_number($saldo) }}</td>
        </tr>
        <tr>
            <td colspan="4" class="text-right"><b>Saldo</b></td>
            <td class="text-right text-nowrap"><b>{{ format_number($saldo) }}</b></td>
        </tr>
    </tbody>
</table>
