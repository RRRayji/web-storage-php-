var is_add_active = false;
var is_rem_active = false;
var header = document.querySelector("header");
var main = document.querySelector(`main`);
var scroller = document.querySelector(`#scroller`);
var add_form = document.querySelector(`#add_form`);
var rem_form = document.querySelector(`#rem_form`);
var notice = document.querySelector(`#notice_window`);
var selected_class = document.querySelector("#selected_class");
var selected_value = document.querySelector("#selected_value");
var lastSelected = null;
var lastEdited = null;
var lastEditedRow = null;
var rows = document.querySelectorAll(".row:not(:first-child)");
var rowsHided = 0;
var r = document.querySelectorAll(".row");
var editButton = document.querySelector("#edit_button");
var tableName = document.querySelector("#first_element");
var editTable = document.querySelector("#edit_table");
var editIdName = document.querySelector("#edit_id_name");
var editId = document.querySelector("#edit_id");
var editColumn = document.querySelector("#edit_column");
var oldValue = document.querySelector("#edited_value");
var newValue = document.querySelector("#new_value");
var remove = document.querySelector("#remove");
var removeState = false;
var remConfirm = document.querySelector("#rem_confirm");
var sq = document.querySelector("#select_query");
var ft = document.querySelector("#fromto_form");
var fin = document.querySelector("#finance");
var tt = document.querySelector("#top10_button");

var searchErrorText = "Неопределённый критерий поиска. (введите 2+ символа)";


function unhideAll()
{
	rows.forEach(row => {
		row.style.display = `flex`;
	});
	rowsHided = 0;
}

function search(event)
{
	if (event.key == "Enter")
	{
		let value = document.querySelector("#search").value.trim().toLowerCase();
		if (value.length < 2)
		{
			unhideAll();
			notify(searchErrorText);
			return;
		}
		unhideAll();
		let isIncludes;
		rows.forEach(row => {
			isIncludes = false;
			let cells = row.querySelectorAll(".cell");
			cells.forEach(cell => {
				if (cell.innerHTML.toLowerCase().includes(value)) isIncludes = true;
			});
			if (!isIncludes)
			{
				row.style.display = `none`;
				++rowsHided;
			}
		});
		//console.log(`сокрыто: ${rowsHided} ?? ${rows.length}`);
		if (rowsHided >= rows.length)
		{
			unhideAll();
			notify(searchErrorText);
			return;
		}
	}
}

function myPrint()
{
	header.style.display = `none`;
	main.style.maxHeight = "none";
	main.style.maxWidth = `570px`;
	main.style.maxWidth = `none`;
	main.style.borderRadius = `0`;
	recalcCellWidth(`24%`);
	recalcRowHeight();
	window.print();
	header.style.display = `flex`;
	recalcCellWidth(`13%`);
	main.style.maxHeight = "89svh";
	main.style.borderRadius = `0 0 20px 20px`;
}

function recalcCellWidth(value)
{
	let cw = r[0].querySelector(".cell").offsetWidth;
	let v = (value == null) ? parseInt(cw*100/window.innerWidth)+1 : value;
	r.forEach(row => {
		let cells = row.querySelectorAll(".cell");
		cells.forEach(cell => {
			cell.style.width = `${v}`;
		});
	});
}

function recalcRowHeight()
{
	let isDataUpdated = false;
	rows.forEach(row => {
		let cells = row.querySelectorAll(".cell");
		cells.forEach(cell => {
			if (cell.offsetHeight > row.offsetHeight)
			{
				isDataUpdated = true;
				row.style.height = `${cell.offsetHeight+2}px`;
			}
		});
	});
	if (isDataUpdated) recalcCellWidth();
}

window.onresize = recalcRowHeight;

function setData()
{
	editTable.value = tableName.innerHTML;
	editIdName.value = lastEditedRow.className.replace("cell", "").trim();
	editId.value = lastEditedRow.innerHTML;
	editColumn.value = selected_class.value;
	oldValue.value = lastEdited.innerHTML;
	newValue.value = document.querySelector("#editor").value;
	console.log("edited");
	editButton.click();
}

document.body.addEventListener('keydown', function(e) {
	if (e.key == "Escape") {
		if (lastEdited != null)
		{
			document.querySelector("#editor").outerHTML = `<div class=\"${lastEdited.className}\">${lastEdited.innerHTML}</div>`;
			lastEdited = null;
		}
		if (lastSelected != null)
		{
			lastSelected.style.backgroundColor = "";
			lastSelected.ondblclick = null;
		}
	}
	else if (e.key == "Delete")
	{
		if (removeState == false)
		{
			remove.click();
			removeState = true;
		}
		else if (removeState == true)
		{
			remConfirm.click();
			removeState = false;
		}
	}
});

window.addEventListener("load", function init(){
	this.removeEventListener("load", init);
	rows.forEach(row => {
		let cells = row.querySelectorAll(".cell");
		cells.forEach(cell => {
			if (cell.offsetHeight > row.offsetHeight) row.style.height = `${cell.offsetHeight+2}px`;
			cell.onclick = function cellClick(){
				selected_class.value = cell.className.replace("cell", "").trim();
				selected_value.value = cell.innerHTML;
				if (lastSelected != null)
				{
					lastSelected.style.backgroundColor = "";
					lastSelected.ondblclick = null;
				}
				cell.style.backgroundColor = `#99b0ce`;
				cell.ondblclick = () => {
					if (lastEdited != null)
					{
						document.querySelector("#editor").outerHTML = `<div class=\"${lastEdited.className}\">${lastEdited.innerHTML}</div>`;
						lastEdited = null;
						lastEditedRow = null;
					}
					lastEdited = cell;
					lastEditedRow = row.firstChild;
					console.log(row.firstChild);
					cell.outerHTML = `<input type=\"text\" id=\"editor\" class="cell ${selected_class.value}" placeholder=\"${selected_value.value}\" onchange=\"setData()\"></input>`;
					cell.focus();
				};
				lastSelected = cell;
			};
		});
	});
	let pix = 150;
	let lc = document.querySelector(".row:first-child").querySelector(".cell:last-child");
	let sw = lc.scrollWidth;
	let cw = get_rect(lc).width;
	while (cw < sw && pix < 200)
	{
		cw = get_rect(lc).width;
		recalcCellWidth(`${pix}px`);
		pix += 10;
	}
});

function wait(ms)
{
	return new Promise(resolve => setTimeout(resolve, ms));
}

function get_rect(element)
{
	return element.getBoundingClientRect();
}

function clear_info()
{
	var arr = document.querySelectorAll('.add_input:not(:last-child)');
	arr.forEach(function (el) {
		el.value = '';
	});
}

async function anim_opacity(form)
{
	for (let i = 0; i < 1; i += 0.1)
	{
		form.style.opacity = `${i}`;
		await wait(15);
	}
}

async function anim_move(form)
{
	for (let i = get_rect(main).top * 1.2; i > get_rect(main).top; i -= 1)
	{
		form.style.top = `${i}px`;
		await wait(5);
	}
}

function display_add_form()
{
	if (is_add_active)
	{
		add_form.style.display = `none`;
		is_add_active = false;
	}
	else
	{
		clear_info();
		add_form.style.left = `${get_rect(main).width * 0.19 - 120}px`;
		
		add_form.style.display = `inline-grid`;
		is_add_active = true;
		
		anim_opacity(add_form);
		anim_move(add_form);


		var firstInput = document.querySelector('.add_input'); // Выбор первого элемента с классом .add_input
		if (firstInput) {
			firstInput.focus(); // Установка фокуса на первый элемент
		}
	}
}


function display_rem_form()
{
	if (is_rem_active)
	{
		rem_form.style.display = `none`;
		is_rem_active = false;
	}
	else
	{
		rem_form.style.left = `${get_rect(main).width * 0.78 - 50}px`;

		rem_form.style.display = `flex`;
		is_rem_active = true;

		anim_opacity(rem_form);
		anim_move(rem_form);
	}
}

function hidequeries()
{
	ft.style.display = `none`;
	fin.style.display = `none`;
}

function display_fromto_form()
{
	hidequeries();
	switch (sq.value)
	{
	case "dates":
		ft.style.display = `flex`;
		anim_opacity(ft);
		anim_move(ft);
		break;
	case "finance":
		fin.style.display = `flex`;
		anim_opacity(fin);
		anim_move(fin);
		break;
	case "top10":
		tt.value = 'select';
		tt.click();
		tt.value = null;
	}
}

async function anim_hide_notice()
{
	for (let i = 1; i >= 0; i -= 0.1)
	{
		notice.style.opacity = `${i}`;
		await wait(40);
	}
	notice.style.opacity = `0`;

	notice.style.display = `none`;
	notice.focused = false;
	is_notice_active = false;
}

async function anim_move_notice()
{
	for (let i = 100; i > 90; i -= 1)
	{
		notice.style.top = `${i}svh`;
		await wait(5);
	}
	await wait(2000);
	notice.onmouseleave = function(){
		this.focused = false;
		this.onmouseleave = null;
	};
	while(notice.focused)
	{
		await wait(20);
	}
	anim_hide_notice();
}

notice.onclick = function(){
	anim_hide_notice();
};

function notify(text)
{
	notice.style.opacity = `0`;
	notice.style.display = `none`;

	notice.onmouseenter = function(){
		this.focused = true;
		this.onmouseenter = null;
	};
	notice.innerHTML =  text.toString().toUpperCase();
	notice.style.display = `flex`;
	is_notice_active = true;

	anim_opacity(notice);
	anim_move_notice();
}

// Обрабатываем событие отправки формы
/*
add_form.addEventListener('submit', function(event) {
	// Предотвращаем стандартное действие отправки формы
	event.preventDefault();

	// Ваш код обработки отправки формы здесь
	// Например, отправка данных с использованием AJAX
	// или другие действия, которые вы хотите выполнить


	// Пример отправки данных с использованием Fetch API
	fetch(add_form.action, {
		method: add_form.method,
		body: new FormData(add_form)
	})
	.then(response => {
		// Обработка ответа от сервера
		// console.log('Form submitted successfully');
	})
	.catch(error => {
		// Обработка ошибки при отправке формы
		console.error('Error submitting form:', error);
	});
});
*/

/*
function display_rem_form()
{
	var cells = document.querySelectorAll('.cell');
	
	// Проходимся по каждой ячейке
	cells.forEach(function(cell) {
		console.log("id: " + cell.innerHTML);
		if (cell.id == id_name)
		{
			cell.addEventListener('onmouseenter', function() {
				var cellNumber = cell.innerHTML;
				// Сохраняем номер ячейки в каком-то месте для последующего использования
				// Выводим номер ячейки в консоль (для тестирования)
				console.log('Нажата ячейка с номером: ' + cellNumber);
			});
		}
	});
	
	// Обработчик события клика на кнопке "удалить"
	document.getElementById('remove').addEventListener('click', function() {
		// Получаем номер ячейки, которую нужно удалить
		var cellNumberToRemove = document.querySelector('.cell[data-cell-number]');
		// Проверяем, есть ли ячейка для удаления
		if (cellNumberToRemove) {
			// Удаляем ячейку
			cellNumberToRemove.remove();
			// Очищаем номер ячейки из атрибута
			cellNumberToRemove.removeAttribute('data-cell-number');
		}
	});
}
*/