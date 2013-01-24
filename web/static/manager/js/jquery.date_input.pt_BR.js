
$.extend(DateInput.DEFAULT_OPTS,
{
	// tradução
	month_names:		["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
	short_month_names:	["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
	short_day_names:	["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],


	stringToDate: function(string)
	{
		var matches;
		if (matches = string.match(/^(\d{4,4})-(\d{2,2})-(\d{2,2})$/))
		{
			return new Date(matches[1], matches[2] - 1, matches[3]);
		}
		else
		{
			return null;
		};
	},


	// formato da data
	dateToString: function(date)
	{
		var month = (date.getMonth() + 1).toString();
		var dom = date.getDate().toString();
		if (month.length == 1) month = "0" + month;
		if (dom.length == 1) dom = "0" + dom;
		return dom + "/" + month + "/" + date.getFullYear();
	}
});