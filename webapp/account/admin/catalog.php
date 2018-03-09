<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/lib/title.php'); ?> Catalog</title>
    <!-- style-->
    <link rel="stylesheet" href="../sharemycar/webapp/css/style.css">
    <link rel="stylesheet" href="css/catalog.css">
	<link rel="stylesheet" href="../../sharemycar/webapp/css/footer.css">
	<link href="../sharemycar/webapp/css/admin/header.css" rel="stylesheet"></link>
	<link href="/sharemycar/webapp/css/catalog.css" rel="stylesheet"></link>
  <link href="/sharemycar/webapp/css/footer.css" rel="stylesheet"></link>
  <!--scripts-->
  <script src="/sharemycar/webapp/js/index.js"></script>
  <title><?php require_once($_SERVER['DOCUMENT_ROOT'].'/sharemycar/webapp/lib/title.php'); ?></title>
  </head>
  <body onLoad="init()">
    <header id="nav">
      <?php require_once($_SERVER['DOCUMENT_ROOT']."/sharemycar/webapp/lib/header_admin.php"); ?>
    </header>
      <div id="manageTitle">
        <label>management catalog</label>
      </div>
      <div id="manageOption">
        <select name="manageselect">
          <option value="">Select catalog</option>
          <option value="STA">States</option>
          <option value="CIT">Cities</option>
          <option value="UNI">Universities</option>
          <option value="BRA">Brands</option>
          <option value="MOD">Models</option>
        </select>
        <input type="text" id="txtCatalogSearch" name="txtCatalogSearch" placeholder="Search">
          <button id="button">New</button>
      </div>
      <div id="manageTable">
        <table id="manageTable01">
          <tr>
            <th>ID</th>
            <th>Model</th>
            <th>Brand</th>
            <th>Status</th>
            <th class="cellIcon">Edit</th>
            <th class="cellIcon">Delete</th>
          </tr>
          <tr>
            <td>1</td>
            <td>FORD GT</td>
            <td>Ford</td>
            <td>Active</td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_edit.png"></td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_delete.png"></td>
          </tr>
          <tr>
            <td>2</td>
            <td>Civic</td>
            <td>Honda</td>
            <td>Active</td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_edit.png"></td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_delete.png"></td>
          </tr>
          <tr>
            <td>3</td>
            <td>Sentra</td>
            <td>Nissan</td>
            <td>Active</td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_edit.png"></td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_delete.png"></td>
          </tr>
          <tr>
            <td>1</td>
            <td>FORD GT</td>
            <td>Ford</td>
            <td>Active</td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_edit.png"></td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_delete.png"></td>
          </tr>
          <tr>
            <td>2</td>
            <td>Civic</td>
            <td>Honda</td>
            <td>Active</td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_edit.png"></td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_delete.png"></td>
          </tr>
          <tr>
            <td>3</td>
            <td>Sentra</td>
            <td>Nissan</td>
            <td>Active</td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_edit.png"></td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_delete.png"></td>
          </tr>
          <tr>
            <td>1</td>
            <td>FORD GT</td>
            <td>Ford</td>
            <td>Active</td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_edit.png"></td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_delete.png"></td>
          </tr>
          <tr>
            <td>2</td>
            <td>Civic</td>
            <td>Honda</td>
            <td>Active</td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_edit.png"></td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_delete.png"></td>
          </tr>
          <tr>
            <td>3</td>
            <td>Sentra</td>
            <td>Nissan</td>
            <td>Active</td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_edit.png"></td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_delete.png"></td>
          </tr>
          <tr>
            <td>1</td>
            <td>FORD GT</td>
            <td>Ford</td>
            <td>Active</td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_edit.png"></td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_delete.png"></td>
          </tr>
          <tr>
            <td>2</td>
            <td>Civic</td>
            <td>Honda</td>
            <td>Active</td>
			<td class="cellIcon"><img src="/sharemycar/webapp/images/icono_edit.png"></td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_delete.png"></td>
          </tr>
          <tr>
            <td>3</td>
            <td>Sentra</td>
            <td>Nissan</td>
            <td>Active</td>
			<td class="cellIcon"><img src="/sharemycar/webapp/images/icono_edit.png"></td>
            <td class="cellIcon"><img src="/sharemycar/webapp/images/icono_delete.png"></td>
          </tr>
        </table>
      </div>
      <footer class="footer footer--black">
        <?php require_once($_SERVER['DOCUMENT_ROOT']."/sharemycar/webapp/lib/footer_admin.php"); ?>
      </footer>
  </body>
</html>
