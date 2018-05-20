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
            <a class="update-dialog-open-link btn btn-success btn-xs" data-update-dialog-title="Select Topping" href="/index.php/Item/SelectItem?item_parent_id=102&amp;category_id=1"><span class="glyphicon glyphicon-hand-up white"></span> </a>                TM1            </td>
        <td>
                       <span class="text-info">
                        តែទឹកដោះគោ                       </span>
        </td>
        <td>
            <input value="6,000" disabled="disabled" class="input-small alignRight readonly form-control" id="price_102" placeholder="Price" data-id="102" maxlength="50" onkeypress="return isNumberKey(event)" name="SaleItem[102][price]" type="text" />            </td>
        <td>
            <form class="line_item_form" id="yw1" action="/index.php/saleItem/editItem?item_id=102&amp;item_parent_id=0" method="post">
                <input value="1" class="input-small input-grid alignRight readonly form-control" id="quantity_102" placeholder="Quantity" data-id="102" data-parentid="0" maxlength="10" name="SaleItem[quantity]" type="text" />
            </form>            </td>
        <td>
            <input value="6,000" disabled="disabled" class="input-small alignRight readonly form-control" name="SaleItem[102][total]" id="SaleItem_102_total" type="text" />            </td>
        <td>
            <a class="delete-item btn btn-danger btn-xs" href="/index.php/saleItem/DeleteItem?item_id=102&amp;item_parent_id=0"><span class="glyphicon glyphicon-trash"></span> </a>            </td>
    </tr>

    </tbody>
</table>