wp.blocks.registerBlockType(
	'zzz-extensions/favorite-movie-quote',
	{
		title: 'Favorite Movie Quote',
		icon: 'dashicons-tickets',
		category: 'text',
		attributes: {
			quote: { type: 'string' }
		},
		edit: function ( props ) {

			function updateQuote( event ) {
				props.setAttributes( { quote: event.target.value } );
			}

			return /*#__PURE__*/React.createElement(
				'div',
				{
					class: 'zzz-block-holder'
				}, /*#__PURE__*/React.createElement(
					'label',
					null,
					'Favorite Quote'
				), /*#__PURE__*/React.createElement(
					'br',
					null
				), /*#__PURE__*/React.createElement(
					'input',
					{
						type: 'text',
						id: 'favorite_quote',
						name: 'favorite_quote',
						value: props.attributes.quote,
						placeholder: 'Enter a quote',
						onChange: updateQuote,
					}
				)
			);
		},
		save: function ( props ) {
			return null;
		},
		// save without callbacl function
		//
		// save: function ( props ) {
		// 	return /*#__PURE__*/React.createElement("div", {
		// 		class: "zzz-block-holder"
		// 	}, /*#__PURE__*/React.createElement("h5", {
		// 		class: "zzz-favorite-quote"
		// 	}, props.attributes.quote));
		// }
	}
);