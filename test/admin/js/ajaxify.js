
	$.fn.ajaxify=function(options)
		{
			var fn=new Array();
			var fd;
			this.find("input:file").change(function(event)
				{
					var dat={};
					dat["field"]=$(this).attr("name");
					dat["file"]=event.target.files[0];
					fn.push(dat);
				});

			var validateFunc=function(){return true;};
			$.fn.ajaxify.defaults={
										url		 : null,
										dataType :'json',
										type 	: "POST",
										cache 	: false,
										contentType : false,
										processData : false,
										cache       : false,
										"onSuccess" : function()
														{		
														},
										"validator" : validateFunc,
										"postdata"	:{}
								  };

			options=$.extend({},$.fn.ajaxify.defaults,options);
				this.submit(function(event)
					{
						event.preventDefault();
						if(options.validator()==true)
						{
							fd=new FormData($(this)[0]);
							if(Object.keys(options.postdata).length>0)
							{
								for(var key in options.postdata)
										{
											fd.append(key,options.postdata[key]);
										}
							}

							$.each(fn,function(idx,val)
							{
								fd.append("files[]",val);
							});

							options["data"]=fd;
							$.ajax(options).done(options.onSuccess);
						}
						else
						{
							var res=options.validator();
							//alert(JSON.stringify(res));
							if(res.status===true)
							{
								fd=new FormData($(this)[0]);
								if(Object.keys(options.postdata).length>0)
									{
										for(var key in options.postdata)
											{
												fd.append(key,options.postdata[key]);
											}
									}

								if(Object.keys(res.postdata).length>0)
									{
										for(var key in res.postdata)
											{
												fd.append(key,res.postdata[key]);
											}
									}

									$.each(fn,function(idx,val)
										{
											fd.append("files[]",val);
										});

										options["data"]=fd;
										//alert(JSON.stringify(options));
										$.ajax(options).done(options.onSuccess);
							}
							else
							{
								return false;
							}
						}
			});
		}