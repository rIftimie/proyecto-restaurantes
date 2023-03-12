import React from 'react';
import KitchenOrderCard from './KitchenOrderCard';

function KitchenOrderContainer({ useStateOrder }) {
	const { orders } = useStateOrder;
	const renderOrders = orders?.map((order) => (
		<KitchenOrderCard
			key={order.id}
			order={order}
			useStateOrder={useStateOrder}
		/>
	));

	return (
		<section className="flex-wrap container-fluid d-flex justify-content-center">
			{renderOrders}
		</section>
	);
}

export default KitchenOrderContainer;
