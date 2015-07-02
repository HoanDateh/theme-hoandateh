<!-- BEGIN: main -->
<!-- BEGIN: tablename -->
<form action="{NV_BASE_SITEURL}index.php" method="get">
	<input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}"/>
	<input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}"/>
	<h3>Chức năng thêm mới fuction cho module dựa vào CSDL sử dụng cho NukeViet 4</h3>
	<table class="table table-striped table-bordered table-hover">
		<tbody>
			<tr>
				<td>Lưu vào module:</td>
				<td>
				<select name="modname">
					<option value=""> -- chọn module -- </option>
					<!-- BEGIN: modname -->
					<option value="{MODNAME.value}" {MODNAME.selected}>{MODNAME.value}</option>
					<!-- END: modname -->
				</select></td>
			</tr>
			<tr>
				<td> Bảng CSDL</td>
				<td>
				<select name="tablename">
					<option value=""> -- chọn bảng dữ liệu -- </option>
					<!-- BEGIN: loop -->
					<option value="{MODNAME.value}" {MODNAME.selected}>{MODNAME.value}</option>
					<!-- END: loop -->
				</select></td>
			</tr>
			<tr>
				<td>Tên function:</td><td><input required="required" oninvalid="setCustomValidity('Dữ liệu này là bắt buộc chỉ dùng các ký tự a-z 0-9 và gạch dưới')" oninput="setCustomValidity('')"  pattern="^[a-z0-9\_]*$"  type="text" name="funname" style="width:150px;" value="{FUNNAME}" /></td>
			</tr>
			<tr>
				<td> Tiêu đề tiếng Anh</td>
				<td><input type="checkbox" name="setlangvi" value="1" checked="checked" /> Sử dụng tên cột và bỏ dấu "_"</td>
			</tr>
			<tr>
				<td> Tiêu đê tiết Việt </td>
				<td><input type="checkbox" name="setlangen" value="1" checked="checked" /> Sử dụng comment của cột</td>
			</tr>
			<tr>
				<td colspan="2" class="text-center"><input class="btn btn-primary" type="submit" value="Thực hiện" /></td>
			</tr>
		</tbody>
	</table>
</form>
<script type="text/javascript">
	$('select[name=modname]').change(function() {
		$("select[name=tablename]").load(script_name + "?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=addfun&loadmodname=" + $(this).val() + "&nocache=" + new Date().getTime());
	});
	$('select[name=tablename]').change(function() {
		var r_split = $(this).val().split('_');
		len = r_split.length - 1;
		$("input[name=funname]").val(r_split[len]);
	});
</script>
<!-- END: tablename -->

<!-- BEGIN: form -->
<form action="{NV_BASE_SITEURL}index.php" method="post">
	<input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}"/>
	<input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}"/>
	<input type="hidden" name="modname" value="{MODNAME}"/>
	<input type="hidden" name="funname" value="{FUNNAME}"/>
	<input type="hidden" name="tablename" value="{TABLENAME}"/>
	<table class="table table-striped table-bordered table-hover">
		<caption>
			Tạo form module {MODNAME}->{FUNNAME} từ bảng: {TABLENAME}
		</caption>
		<thead>
			<tr>
				<th>Tên cột</th>
				<th>Loại dữ liệu</th>
				<th>Kiểu hiển thị trong Forrm</th>
				<th>Bắt buộc</th>
				<th>Hidden</th>
				<th>List</th>
				<th>Tiêu đề tiếng Việt</th>
				<th>Tiêu đề tiếng Anh</th>
			</tr>
		</thead>
		<tbody>
		<!-- BEGIN: column -->
			<tr id="column_{COLUMN.column_name}">
				<td>{COLUMN.column_name}</td>
				<td>{COLUMN.data_type}</td>
				<td>
				<select name="views[{COLUMN.column_name}]}">
					<!-- BEGIN: field_type -->
					<option value="{FIELD_TYPE.key}" {FIELD_TYPE.selected}>{FIELD_TYPE.value}</option>
					<!-- END: field_type -->
				</select></td>
				<td align="center"><input type="checkbox" name="requireds[{COLUMN.column_name}]" value="1" {COLUMN.required_checked}/></td>
				<td align="center"><input type="checkbox" name="hiddens[{COLUMN.column_name}]" value="1" {COLUMN.hidden_checked}/></td>
				<td align="center"><input type="checkbox" name="listviews[{COLUMN.column_name}]" value="1" {COLUMN.listview_checked}/></td>
				<td><input required="required" type="text" name="title_vi[{COLUMN.column_name}]" value="{COLUMN.title_vi}" style="width: 180px"/></td>
				<td><input required="required" type="text" name="title_en[{COLUMN.column_name}]" value="{COLUMN.title_en}" style="width: 180px"/></td>
			</tr>
		<!-- END: column -->
		</tbody>
	</table>
	<table class="table table-striped table-bordered table-hover">
		<caption>
			Các chức năng của function {MODNAME}->{FUNNAME}
		</caption>
		<colgroup>
			<col style="width: 50%" />
		</colgroup>
		<tbody>
			<tr>
				<td>Chức năng phân trang</td><td><input type="checkbox" name="generate_page" value="1" {GENERATE_PAGE_CHECKED}/></td>
			</tr>
			<tr>
				<td>Chức năng tìm kiếm</td><td><input type="checkbox" name="search_page" value="1" {SEARCH_PAGE_CHECKED}/></td>
			</tr>
			<tr>
				<td>Chức năng sắp xếp thứ tự</td>
				<td><select name="weight_page">
					<option value="" >-- Chọn trường sắp xếp --</option>
					<!-- BEGIN: weight_page -->
					<option value="{FIELD_TYPE.key}" {FIELD_TYPE.selected}>{FIELD_TYPE.value}</option>
					<!-- END: weight_page -->
				</select></td>
			</tr>
			<tr>
				<td>Chọn cột tiêu đề để lấy làm alias</td>
				<td><select name="alias_title">
					<option value="" >-- Chọn trường --</option>
					<!-- BEGIN: alias_title -->
					<option value="{FIELD_TYPE.key}" {FIELD_TYPE.selected}>{FIELD_TYPE.value}</option>
					<!-- END: alias_title -->
				</select></td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td align="center" colspan="2"><input class="btn btn-primary" type="submit" value="Thực hiện" /></td>
			</tr>
		</tfoot>
	</table>
</form>
<!-- END: form -->
<!-- END: main -->