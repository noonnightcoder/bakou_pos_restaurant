<table class="table table-hover table-condensed">
    <thead>
    <tr>
        <th>Item Code</th>
        <th>Item Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody id="cart_contents">
    <tr>
        <td>
            <a class="update-dialog-open-link btn btn-success btn-xs" data-update-dialog-title="Select Topping" href="/index.php/Item/SelectItem?item_parent_id=296&amp;category_id=1"><span class="glyphicon glyphicon-hand-up white"></span> </a>                IL            </td>
        <td>
                       <span class="text-info">
                        Iced latte                       </span>
        </td>
        <td>
            <input value="9,000" disabled="disabled" class="input-small alignRight readonly form-control" id="price_296" placeholder="Price" data-id="296" maxlength="50" onkeypress="return isNumberKey(event)" name="SaleItem[296][price]" type="text" />            </td>
        <td>
            <form class="line_item_form" id="yw1" action="/index.php/saleItem/editItem?item_id=296&amp;item_parent_id=0" method="post">
                <input value="1" class="input-small input-grid alignRight readonly form-control" id="quantity_296" placeholder="Quantity" data-id="296" data-parentid="0" maxlength="10" name="SaleItem[quantity]" type="text" />
            </form>            </td>
        <td>
            <input value="9,000" disabled="disabled" class="input-small alignRight readonly form-control" name="SaleItem[296][total]" id="SaleItem_296_total" type="text" />            </td>
        <td>
            <a class="delete-item btn btn-danger btn-xs" href="/index.php/saleItem/DeleteItem?item_id=296&amp;item_parent_id=0"><span class="glyphicon glyphicon-trash"></span> </a>            </td>
    </tr>
    <tr>
        <td>
            <a class="update-dialog-open-link btn btn-success btn-xs" data-update-dialog-title="Select Topping" href="/index.php/Item/SelectItem?item_parent_id=44&amp;category_id=9"><span class="glyphicon glyphicon-hand-up white"></span> </a>                NH            </td>
        <td>
                       <span class="text-info">
                        មីបន្ទះដែក                       </span>
        </td>
        <td>
            <input value="10,000" disabled="disabled" class="input-small alignRight readonly form-control" id="price_44" placeholder="Price" data-id="44" maxlength="50" onkeypress="return isNumberKey(event)" name="SaleItem[44][price]" type="text" />            </td>
        <td>
            <form class="line_item_form" id="yw2" action="/index.php/saleItem/editItem?item_id=44&amp;item_parent_id=0" method="post">
                <input value="1" class="input-small input-grid alignRight readonly form-control" id="quantity_44" placeholder="Quantity" data-id="44" data-parentid="0" maxlength="10" name="SaleItem[quantity]" type="text" />
            </form>            </td>
        <td>
            <input value="20,000" disabled="disabled" class="input-small alignRight readonly form-control" name="SaleItem[44][total]" id="SaleItem_44_total" type="text" />            </td>
        <td>
            <a class="delete-item btn btn-danger btn-xs" href="/index.php/saleItem/DeleteItem?item_id=44&amp;item_parent_id=0"><span class="glyphicon glyphicon-trash"></span> </a>            </td>
    </tr>
    </tbody>
</table>