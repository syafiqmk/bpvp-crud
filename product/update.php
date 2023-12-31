<?php 
    $id = $_GET['id'];

    $s_product = "SELECT * FROM products WHERE id = $id";
    $q_s_product = mysqli_query($conn, $s_product);
    $d_product = mysqli_fetch_object($q_s_product);

    if(isset($_POST['submit'])) {
        $name = ucwords($_POST['name']);
        $desc = ucfirst($_POST['description']);
        $price = $_POST['price'];
        $qty = $_POST['quantity'];
        
        if(empty($_FILES['image']['name'])) {
            $img_name = $d_product->image;
        } else {
            $img_name = $_FILES['image']['name'];
            $img_tmp = $_FILES['image']['tmp_name'];
            $dir = "uploads/img/";
            move_uploaded_file($img_tmp, $dir.$img_name);
        }

        $u_product = "UPDATE products SET name = '$name', image = '$img_name', description = '$desc', price = '$price', quantity = '$qty' WHERE id = $id";
        $q_u_product = mysqli_query($conn, $u_product);
        
        if($q_u_product) {
            header("location:index.php?page=product-index");
        }
    }
?>

<h1>Edit Data</h1>

<div class="form">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="input-group">
            <label for="name">Nama Barang</label>
            <input type="text" name="name" id="name" autocomplete="off" required value="<?= htmlspecialchars($d_product->name) ?>">
        </div>

        <div class="input-group">
            <label for="image">Gambar</label>
            <?php 
                if(!empty($d_product->image)) { ?>
                    <img src="uploads/img/<?= $d_product->image ?>" alt="<?= $d_product->name ?>">
                <?php }
            ?>
            <input type="file" name="image" id="image">
        </div>

        <div class="input-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" cols="30" rows="10"><?= htmlspecialchars($d_product->description) ?></textarea>
        </div>

        <div class="input-group">
            <label for="price">Harga Satuan</label>
            <input type="number" name="price" id="price" autocomplete="off" min="0" required value="<?= htmlspecialchars($d_product->price) ?>">
        </div>

        <div class="input-group">
            <label for="quantity">Qty</label>
            <input type="number" name="quantity" id="quantity" autocomplete="off" min="0" required value="<?= htmlspecialchars($d_product->quantity) ?>">
        </div>

        <div class="form-button">
            <button type="submit" name="submit" class="btn primary"><span class="fa fa-floppy-disk"></span> Simpan</button>
            <a href="index.php?page=product-index" class="btn danger"><span class="fa fa-xmark"></span> Cancel</a>
        </div>
    </form>
</div>