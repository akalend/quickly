// Ниже файл автокомплита
autocomplete = {
	min_lenght 		: 2, 			// минимальная длинна введенных символом перед началом отправки запроса
	last_request 	: "",			// последний запрос, кеш от повторного запроса на сервер
	object 			: "", 			// объект с полем для автокомплита
	items 			: new Array(), 	// массив с результатами для отрисовки
	objectfocus 	: null 			// поле для хранения интервала фокуса элемента
};

/**
 * 
 * @param objectId
 */
autocomplete.init = function ( object_selector )
{
	autocomplete.object = $(object_selector);
	autocomplete.object.bind("keyup", autocomplete.changefeeld);
	autocomplete.object.bind("focus", autocomplete.changefeeld);
	autocomplete.object.bind("click", autocomplete.changefeeld);

	autocomplete.object.bind("focusout", function () {
		var timeoutfunction = function() 
		{ 
			$("#autocomlite-block").remove();
			clearInterval (autocomplete.objectfocus);
		};
		autocomplete.objectfocus = setInterval(timeoutfunction, 2000)
	});
}

// срабатывает при изменении 
autocomplete.changefeeld = function ( ) 
{
	// проверяем длинну запроса
	if (autocomplete.object.val().length < 2) {
		$("#autocomlite-block").remove();
		return false;
	}

	// проверяем изменился ли запрос
	if (autocomplete.last_request != autocomplete.object.val())
	{
		autocomplete.last_request = autocomplete.object.val();
		
		// Выполняем запрос к серверу
		autocomplete.items = autocomplete.sendrequest();
	}

	autocomplete.draw ();
}

// функция отрисовки результатов
autocomplete.draw = function (  )
{
	var block_obj = $("#autocomlite-block");
	// Создаем новый блок
	if (block_obj.length == 0) {
		$("html").append ('<div id="autocomlite-block"></div>');
		block_obj = $("#autocomlite-block");
	}
	
	block_obj.html ("");
	for ( key in autocomplete.items ) 
	{
		var item = autocomplete.items[key];
		item = item.replace(autocomplete.last_request, '<span class="highlight">'+autocomplete.last_request+'</span>');

		var item_html 	=  '<div id="autocomplite-result-item-'+key+'" class="autocomplite-result-item">';
		item_html 		+= '<a href="javascript:autocomplete.selectitem('+key+')">';
		item_html 		+= item+"</a></div>";
		
		//alert (item_html);
		
		block_obj.append(item_html);
	}

	// цепляем события 
	// $("div.autocomplite-result-item").bind("click", function () { alert ("asd")});

	// Позиционируем
	$(block_obj).width ( $(autocomplete.object).innerWidth () );
	var offset = $(autocomplete.object).offset ();
	$(block_obj).offset({
		top: offset.top + $(autocomplete.object).outerHeight(), 
		left: offset.left
	});
	

}

// выбираем запись
autocomplete.selectitem = function ( key )
{
	$(autocomplete.object).val( $("#autocomplite-result-item-"+key).text() );
	$(autocomplete.object).focus();
	clearInterval (autocomplete.objectfocus);
	autocomplete.changefeeld ();
	
}

