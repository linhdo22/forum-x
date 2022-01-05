<form method="POST" action="../payment/vnpay.php">
    <input type="hidden" value="110000" name="order_type">
    <input type="hidden" value="1" name="redirect">
    <div class="input-group mb-3">
        <span class="input-group-text">Amount</span>
        <input type="text" class="form-control" name="amount">
        <span class=" input-group-text">VND</span>
    </div>
    <div class="input-group mb-3">
        <span class="input-group-text">Message</span>
        <textarea name="order_desc" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <select class="form-select" name="bank_code">
            <option selected value="NCB"> Ngân hàng Quốc dân (NCB) </option>
            <option value="ABBANK"> Ngân hàng thương mại cổ phần An Bình (ABBANK) </option>
            <option value="ACB"> Ngân hàng ACB </option>
            <option value="AGRIBANK"> Ngân hàng Nông nghiệp (Agribank) </option>
            <option value="BACABANK"> Ngân Hàng TMCP Bắc Á </option>
            <option value="BIDV"> Ngân hàng đầu tư và phát triển Việt Nam (BIDV) </option>
            <option value="DONGABANK"> Ngân hàng Đông Á (DongABank) </option>
            <option value="EXIMBANK"> Ngân hàng EximBank </option>
            <option value="HDBANK"> Ngan hàng HDBank </option>
            <option value="IVB"> Ngân hàng TNHH Indovina (IVB) </option>
            <option value="MBBANK"> Ngân hàng thương mại cổ phần Quân đội </option>
            <option value="MSBANK"> Ngân hàng Hàng Hải (MSBANK) </option>
            <option value="NAMABANK"> Ngân hàng Nam Á (NamABank) </option>
            <option value="OCB"> Ngân hàng Phương Đông (OCB)</option>
        </select>
    </div>
    <div class="mb-3">
        <select class="form-select" name="language">
            <option selected value="vn"> Vietnamese </option>
            <option value="en"> English </option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary w-100 mx-auto">Donate</button>
</form>