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
            <a class="update-dialog-open-link btn btn-success btn-xs" data-update-dialog-title="Select Topping" href="/index.php/Item/SelectItem?item_parent_id=61&amp;category_id=9"><span class="glyphicon glyphicon-hand-up white"></span> </a>                GSS            </td>
        <td>
                       <span class="text-info">
                        ស៊ុបយ៉ិនស៊ិន                       </span>
        </td>
        <td>
            <input value="10,000" disabled="disabled" class="input-small alignRight readonly form-control" id="price_61" placeholder="Price" data-id="61" maxlength="50" onkeypress="return isNumberKey(event)" name="SaleItem[61][price]" type="text" />            </td>
        <td>
            <form class="line_item_form" id="yw5" action="/index.php/saleItem/editItem?item_id=61&amp;item_parent_id=0" method="post">
                <input value="1" class="input-small input-grid alignRight readonly form-control" id="quantity_61" placeholder="Quantity" data-id="61" data-parentid="0" maxlength="10" name="SaleItem[quantity]" type="text" />
            </form>            </td>
        <td>
            <input value="10,000" disabled="disabled" class="input-small alignRight readonly form-control" name="SaleItem[61][total]" id="SaleItem_61_total" type="text" />            </td>
        <td>
            <a class="delete-item btn btn-danger btn-xs" href="/index.php/saleItem/DeleteItem?item_id=61&amp;item_parent_id=0"><span class="glyphicon glyphicon-trash"></span> </a>            </td>
    </tr>
    <tr>
        <td>
            <a class="update-dialog-open-link btn btn-success btn-xs" data-update-dialog-title="Select Topping" href="/index.php/Item/SelectItem?item_parent_id=78&amp;category_id=9"><span class="glyphicon glyphicon-hand-up white"></span> </a>                S5            </td>
        <td>
                       <span class="text-info">
                        ដំឡូងបារាំងបំពង                       </span>
        </td>
        <td>
            <input value="6,500" disabled="disabled" class="input-small alignRight readonly form-control" id="price_78" placeholder="Price" data-id="78" maxlength="50" onkeypress="return isNumberKey(event)" name="SaleItem[78][price]" type="text" />            </td>
        <td>
            <form class="line_item_form" id="yw6" action="/index.php/saleItem/editItem?item_id=78&amp;item_parent_id=0" method="post">
                <input value="1" class="input-small input-grid alignRight readonly form-control" id="quantity_78" placeholder="Quantity" data-id="78" data-parentid="0" maxlength="10" name="SaleItem[quantity]" type="text" />
            </form>            </td>
        <td>
            <input value="6,500" disabled="disabled" class="input-small alignRight readonly form-control" name="SaleItem[78][total]" id="SaleItem_78_total" type="text" />            </td>
        <td>
            <a class="delete-item btn btn-danger btn-xs" href="/index.php/saleItem/DeleteItem?item_id=78&amp;item_parent_id=0"><span class="glyphicon glyphicon-trash"></span> </a>            </td>
    </tr>
    </tbody>
</table>