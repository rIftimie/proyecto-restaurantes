import React from 'react';
import { getProducts } from '../../helpers/kitchen';

function HomePage() {
	const [products, setProducts] = useState([]);

	const fetchGetProducts = async () => {
		const response = await getProducts();
		setProducts(response);
	};

	return <main></main>;
}

export default HomePage;
