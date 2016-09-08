<div class="contInformation">
	
	<div class="infoArticulo">
		
		<div class="sliderStore">

			<ul class="sliderContenido">
			
				<li class="imageInfo" ng-repeat="image in item.images_slider" load-desc-gen-item>
					<img src="./src/images/articulos/{{image}}">
				</li>

			</ul>

			<div class="itemSliderConten">
				<ul>
					<li ng-repeat="image in item.images_slider" load-desc-gen-item>
						<img ng-if="$index==0"  src="./src/images/seitem.png">
						<img ng-if="$index!=0"  src="./src/images/seitemnot.png">
					</li>
				</ul>
			</div>
			
		</div>
		<!--Detalle del Producto-->
		<div class="descInfo">
			<span class="descritem">{{item.name}}</span><br><br>
			<span class="price_not">{{item.price | currency }}</span>
			<span class="price_yes">{{item.not_price | currency}}</span>
			<p>{{item.descripcion}}</p>
			<p>Marca: {{item.marca}}</p>
		</div>

	</div>

	
	<div class="paypal">
		<a href="{{item.paypal}}" target="_blank"><img src="./src/images/buynow.es.png" style="width: 80%; height: auto; margin: 0 auto;"></a>
	</div>
	

</div>