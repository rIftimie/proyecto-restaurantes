import React, { useEffect, useState } from 'react';
import { getProducts } from '../../helpers/kitchen';
import Menu from './Menu';

function HomePage() {
	const [products, setProducts] = useState([]);

	const fetchGetProducts = async () => {
		const response = await getProducts();
		setProducts(response);
	};

	useEffect(() => {
		fetchGetProducts();
	}, []);

	return (
		<main>
			<Menu products={products} />
		</main>
	);
}

export default HomePage;
