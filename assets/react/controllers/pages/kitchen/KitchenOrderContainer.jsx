import React from 'react';
import KitchenOrderCard from './KitchenOrderCard';

function KitchenOrderContainer({ useStateOrder }) {
	const orders = useStateOrder.orders;

	const renderOrders = orders?.map((order) => (
		<KitchenOrderCard
			key={order.id}
			order={order}
			useStateOrder={useStateOrder}
		/>
	));

	return (
		<main className="d-flex flex-column flex-lg-row">{renderOrders}</main>
	);
}

export default KitchenOrderContainer;
