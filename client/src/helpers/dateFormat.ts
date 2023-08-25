export const formatDateString = (dateString: string): string => {
  const date = dateString.split('T')[0];
  const [year, month, day] = date.split('-');

  return day + '/' + month + '/' + year;
};
