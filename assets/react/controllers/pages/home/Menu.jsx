import React from 'react';

function Menu({ products }) {
	const renderProducts = products?.map((product) => (
		<article className="m-3 card col-3 d-flex justify-content-between">
			<header className="d-flex">
				<img src={product.img} alt={product.name + '-image'} />
				<h2 className="p-3">
					{product.name.charAt(0).toUpperCase() + product.name.slice(1)}
				</h2>
			</header>
			<div className="p-3 bg-dark rounded-bottom">
				<p>{product.description}</p>
				<p className="text-end text-light fs-3">{product.price} €</p>
			</div>
		</article>
	));

	return (
		<section className="flex-wrap container-fluid d-flex justify-content-center">
			{renderProducts}
		</section>
	);
}

export default Menu;
