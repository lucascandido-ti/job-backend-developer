

<!DOCTYPE html>
<html lang="pt">
<style>

    table{
        margin: 0;
        padding: 0;
    }

    table thead{
        background-color: #725BC2;
    }

    table thead th{
        padding: 15px 5px 15px 5px;
        background-color: transparent;
        color: white;
        font-size: 13px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

    
    table tbody tr td{
        padding: 0px 15px 0px 15px;
        color: black;
        font-size: 12px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }
    

</style>
<body>

    <table>
        <thead>
            <th>Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Category</th>
            @if ($product->image_url != "")
                <th>Image</th>
            @endif
        </thead>
        <tbody>
            <tr>
                <td>{{$product->name}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->description}}</td>
                <td>{{$product->category}}</td>
                @if ($product->image_url != "")
                    <td>
                        <img width="80px" height="80px" src={{$product->image_url}} />
                    </td>
                @endif
                
            </tr>
            
        </tbody>
    </table>
</body>
</html>