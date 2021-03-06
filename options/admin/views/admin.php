<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   GPSTrackingBlog
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */
?>

<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>



	<div class="options-panel">
		<?php
		$screen = get_current_screen();
		$i = 0;
		$sectionList = '';
		$sectionBody = '';
		$active = '';
		if (isset($_GET['page'])){
			$activeSect = str_replace($this->slug . '-', '', $_GET['page']);
			$activeSect = str_replace($this->slug, '', $activeSect);
		} else {
			$activeSect = '';
		}
        if (!isset($this->optionsArray[$activeSect])) {
            reset($this->optionsArray);
            $activeSect = key($this->optionsArray);
        }

        $title = $this->optionsArray[$activeSect]['name'];
        if (isset($this->optionsArray[$activeSect]['desc'])) {
            $description = $this->optionsArray[$activeSect]['desc'];
        }
        else  {
            $description =  '';
        }

		?>
		<div class="panel-header">
			<h2><?php echo $title; ?></h2>
			<p class="section-description"><?php echo $description; ?></p>
		</div>
		<div class="sections-section">
			<div class="sections-list">
				<ul>
					<?php foreach ($this->optionsArray as $sectId => $sectValue) {

                        if (isset($sectValue['desc'])) {
                            $sectionDesc = $sectValue['desc'];
                        }
                        else  {
                            $sectionDesc = '';
                        }

                        if ($activeSect == $sectId) {
                            $active = 'active';
                        } else {
                            $active = '';
                        }
                        echo '<li><a href="#" id="'. $sectId.'" class="'.$active.'" data-section="section_'.$sectId.'" data-description="'.$sectionDesc.'">'.$sectValue['name'].'</a></li>';
                    }

                    ?>
				</ul>
			</div>
			<div class="sections-body">
				<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>">
					<?php wp_nonce_field('update-atfOptions', 'update-atfOptions'); ?>
					<?php
                    foreach ($this->optionsArray as $sectId => $sectValue) {
                        $options = get_option($this->slug.'_'.$sectId);

                        if ($activeSect == $sectId) {
                            $i++;
                            $active = 'active';
                        } else {
                            $active = '';
                        }
                        ?>

                    <div id="section_<?php echo $sectId; ?>" class="one-section-body atf-fields <?php echo $active; ?>">
                        <table class="form-table"><tbody>


                        <?php



                        if (isset($sectValue['content'])) {
                            echo $sectValue['content'];
                        }
                        if (isset($sectValue['incFile'])) {

                        }
                        if (isset($sectValue['items'])) {

                            foreach ( $sectValue['items'] as $itemId => $item ) {

	                            $item['id'] = $sectId . '_' . $itemId;

	                            $item['name'] = $this->slug.'['.$sectId.']['.$itemId.']';

                                if ($item['type'] == 'title') {

                                    echo  '<tr>';
                                    echo  '<th scope="row" colspan="2"><h3 class="title">'.$item['title'].'</h3></th>';
                                    echo  '</tr>';

                                } elseif ($item['type'] == 'group') {

                                    if (!isset($options[$itemId]) && isset($item['default'])) {
                                        $item['value'] = $item['default'];
                                    } else {
                                        $item['value'] = $options[$itemId];
                                    }

                                    echo  '<tr><th scope="row" colspan="2">';
                                    echo  '<h3 class="title">'.$item['title'].'</h3>';
                                    if (isset($item['desc'])) echo '<p class="description">'.$item['desc'].'</p>';
                                    echo  '</th></tr>';
                                    echo  '<tr>';
                                    echo  '<td scope="row" colspan="2" class="group-container">';

									call_user_func(array('AtfHtmlHelper', $item['type']), $item);

                                    echo  '</td>';
                                    echo  '</tr>';


                                } else {

                                    if (!isset($options[$itemId]) && isset($item['default'])) {
                                        $item['value'] = $item['default'];
                                    } else {
                                        $item['value'] = $options[$itemId];
                                    }

                                    echo  '<tr>';
                                    echo  '<th scope="row"><label for="'.$itemId.'">'.$item['title'].'</label></th>';
                                    echo  '<td>';
									call_user_func(array('AtfHtmlHelper', $item['type']), $item);
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            }

                        }

                        ?>


                            </tbody></table>
                        </div>

                        <?php

                    }

                    ?>
					<div class="bottom submit-panel">
						<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
					</div>
				</form>

			</div>
		</div>
	</div>

</div>
