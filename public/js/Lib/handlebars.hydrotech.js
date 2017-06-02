var JST = [];
_.each(TMPL, function(template,name){
  JST[name] = Handlebars.compile(template);
  Handlebars.registerPartial(name, template);
});
Handlebars.registerHelper("toHuman", function(timestamp) {
     return (new Date(timestamp*1000)).toLocaleDateString();
});