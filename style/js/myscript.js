var is_active = false;
var scroller = document.querySelector(`#scroller`);
var add_form = document.querySelector(`#add_form`);
var main = document.querySelector(`main`);

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
	arr.forEach(function(el) {
		el.value = '';
	});
}

async function anim_opacity()
{
	for (let i = 0; i < 1; i += 0.1)
	{
		add_form.style.opacity = `${i}`;
		await wait(15);
	}
}

async function anim_move()
{
	for (let i = get_rect(main).top * 1.2; i > get_rect(main).top; i -= 1)
	{
		add_form.style.top = `${i}px`;
		await wait(5);
	}
}

function display_add_form()
{
	if (is_active)
	{
		add_form.style.display = `none`;
		is_active = false;
	}
	else
	{
		clear_info();
		let le = get_rect(main).width * 0.35 - 120;
		add_form.style.left = `${le}px`;
		
		add_form.style.display = `inline-grid`;
		is_active = true;
		
		anim_opacity();
		anim_move();

		
		var inps = document.querySelectorAll('.add_input');
		inps.forEach(function(el) {
			el.focus();
			return;
		});
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