// 展開分類選單
  function toggleParts(categoryId) {
    const list = document.getElementById('parts-' + categoryId);
    list.style.display = list.style.display === 'none' ? 'block' : 'none';
  }

  // 選擇某個商品
  function selectPart(categoryId, partName, partId) {

    const selected = document.getElementById('selected-' + categoryId);
    selected.textContent = '已選：' + partName;

    // 記錄選擇（可改為送入隱藏欄位、localStorage等）
    console.log("選擇商品：分類", categoryId, "商品ID", partId);
	
	// ✅ 更新或建立一個隱藏 input，用來送出這個分類的選擇
	  let input = document.querySelector(`input[name="selected_parts[${categoryId}]"]`);
	  if (!input) {
		input = document.createElement('input');
		input.type = 'hidden';
		input.name = `selected_parts[${categoryId}]`;
		document.getElementById('selectionForm').appendChild(input);
	  }
	  input.value = partId;
  }

  // ✅ 取消選擇商品
  function cancelSelection(categoryId) {
	
    const selected = document.getElementById('selected-' + categoryId);
    selected.textContent = '（尚未選擇）';

    // 清除記錄（如使用 localStorage 或隱藏 input 也要一起清除）
    console.log("取消選擇：分類", categoryId);
  }
  
	document.addEventListener('DOMContentLoaded', function () {
	  const form = document.querySelector('form[action="cart/add_to_cart.php"]');
	  if (form) {
		form.addEventListener('submit', function(e) {
		  const formData = new FormData(document.getElementById('selectionForm'));
		  const selected = {};
		  for (const [key, value] of formData.entries()) {
			const match = key.match(/selected_parts\[(\d+)\]/);
			if (match) {
			  const categoryId = match[1];
			  if (value) selected[categoryId] = parseInt(value);
			}
		  }
		  document.getElementById('cartData').value = JSON.stringify(selected);
		});
	  }
	});

