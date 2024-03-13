var id_name = "ид";
var is_add_active = false;
var is_rem_active = false;
var scroller = document.querySelector(`#scroller`);
var add_form = document.querySelector(`#add_form`);
var rem_form = document.querySelector(`#rem_form`);
var main = document.querySelector(`main`);
var selected_class = document.querySelector("#selected_class");
var selected_value = document.querySelector("#selected_value");
var last_selected = null;


/*
	var sel = document.querySelector("#select_ид-товар");
	console.log(sel.options[sel.selectedIndex].innerHTML);	//	moloko
*/

document.querySelector("body").onmouseenter = function ()
{
	let rows = document.querySelectorAll(".row:not(:first-child)");
	rows.forEach(row => {
		let cells = row.querySelectorAll(".cell");
		cells.forEach(cell => {
			cell.onclick = function (){
				selected_class.value = cell.className.replace("cell", "").trim();
				selected_value.value = cell.innerHTML;
				if (last_selected != null) last_selected.style.backgroundColor = "";
				last_selected = cell;
				cell.style.backgroundColor = `#99b0ce`;
			};
		});
	});
	let len = document.querySelector(".row:first-child").querySelectorAll(".cell").length;
	scroller.onmouseenter = null;
};

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
		add_form.style.left = `${get_rect(main).width * 0.35 - 120}px`;
		
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
	if (is_add_active)
	{
		rem_form.style.display = `none`;
		is_add_active = false;
	}
	else
	{
		rem_form.style.left = `${get_rect(main).width * 0.65 - 50}px`;

		rem_form.style.display = `flex`;
		is_add_active = true;

		anim_opacity(rem_form);
		anim_move(rem_form);
	}
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