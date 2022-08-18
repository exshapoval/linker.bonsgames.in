<?php

function create_page_nav($current_page, $total_count, $href, $perpage = 20, $label = 'page', $name = false)
{
    $params = $_GET;
    unset($params['page']);
    unset($params[$label]);
    if ($params)
    {
        $href .= (strpos($href, '?') ? '&' : '?') . http_build_query($params);
    }

    $href .= (strpos($href, '?') ? '&' : '?') . $label . '=';

    $page_nav = '';

    if ($current_page)
    {
        $page_nav .= '<a href="'. $href . ($current_page-1) . ($name ? '#names' : '').'">&lt;&lt;</a> | ';
    }

    $last_page = (int)(($total_count-1) / $perpage);

    $page_start = max($current_page - 9, 0);
    $page_end = min($current_page +9, $last_page);

    while ($page_end - $page_start >= 10)
    {
        if ($page_end - $current_page > $current_page - $page_start)
        {
            $page_end --;
        }
        else
        {
            $page_start ++;
        }
    }

    if ($page_start != $page_end)
    {
        for ($i= $page_start; $i<= $page_end; $i++)
        {
            if ($i == $current_page)
            {
                $page_nav .= '<strong>' . ($i+1) .'</strong>';
            }
            else
            {
                $page_nav .= '<a href="'. $href . $i . ($name ? '#names' : '') . '">'. ($i+1) .'</a>';
            }
            if ($i<$page_end)
            {
                $page_nav .= ' | ';
            }
        }

        if ($current_page < $last_page)
        {
            $page_nav .= ' | <a href="'. $href . ($current_page+1) . ($name ? '#names' : '') . '"> >></a>';
        }
    }

    if ($total_count)
    {
        $page_nav .= ($page_nav ? '&nbsp;&nbsp;&nbsp;' : '') . ($current_page * $perpage + 1) .' - '. min($total_count, ($current_page + 1) * $perpage) .' из '. $total_count;
    }

    return $page_nav;
}

function getSort($key, $delpage = false)
{
    $params = $_GET;
    if ($delpage) unset($params['page']);

    if (isset($params['sort']) && $params['sort'] == $key)
    {
        $params['dir'] = isset($params['dir']) && $params['dir'] == 'desc' ? 'asc' : 'desc';
    }
    else
    {
        $params['sort'] = $key;
        $params['dir'] = 'asc';
    }

    return '?'. http_build_query($params);
}